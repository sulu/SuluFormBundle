<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Sulu\Bundle\FormBundle\Configuration\FormConfigurationInterface;
use Sulu\Bundle\FormBundle\Configuration\MailConfigurationInterface;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Event\FormEvent;
use Sulu\Bundle\FormBundle\Mail;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Twig\Environment;

/**
 * Handling of form based on form configuration.
 */
class Handler implements HandlerInterface
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var MediaManager
     */
    protected $mediaManager;

    /**
     * @var Mail\HelperInterface
     */
    protected $mailHelper;

    /**
     * @var array
     */
    protected $attachments = [];

    public function __construct(
        ObjectManager $entityManager,
        Mail\HelperInterface $mailHelper,
        Environment $twig,
        EventDispatcherInterface $eventDispatcher,
        MediaManager $mediaManager
    ) {
        $this->entityManager = $entityManager;
        $this->mailHelper = $mailHelper;
        $this->twig = $twig;
        $this->eventDispatcher = $eventDispatcher;
        $this->mediaManager = $mediaManager;
        $this->attachments = [];
    }

    /**
     * Handle form.
     */
    public function handle(FormInterface $form, FormConfigurationInterface $configuration): bool
    {
        if (!$form->isValid()) {
            return false;
        }

        $mediaIds = $this->uploadMedia($form, $configuration);
        $this->mapMediaIds($form->getData(), $mediaIds);
        $this->save($form, $configuration);
        $this->sendMails($form, $configuration);

        return true;
    }

    /**
     * Save form.
     */
    private function save(FormInterface $form, FormConfigurationInterface $configuration): void
    {
        $this->eventDispatcher->dispatch(
            new FormEvent(
                $form,
                $configuration
            ),
            self::EVENT_FORM_SAVE
        );

        if (!$configuration->getSave()) {
            return;
        }

        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(
            new FormEvent(
                $form,
                $configuration
            ),
            self::EVENT_FORM_SAVED
        );
    }

    private function sendMails(FormInterface $form, FormConfigurationInterface $configuration): void
    {
        if ($adminMailConfiguration = $configuration->getAdminMailConfiguration()) {
            $this->sendMail($form, $adminMailConfiguration);
        }

        if ($websiteMailConfiguration = $configuration->getWebsiteMailConfiguration()) {
            $this->sendMail($form, $websiteMailConfiguration);
        }
    }

    private function sendMail(FormInterface $form, MailConfigurationInterface $configuration): void
    {
        // TODO FIXME this is currently the only way to get the medias to the email view.
        $additionalData = [];
        $formData = $form->getData();
        if ($formData instanceof Dynamic) {
            $additionalData = [
                'formEntity' => $formData->getForm()->serializeForLocale($configuration->getLocale(), $formData),
            ];
        }

        $body = $this->twig->render(
            $configuration->getTemplate(),
            array_merge(
                $configuration->getTemplateAttributes(),
                $additionalData
            )
        );

        $this->mailHelper->sendMail(
            $configuration->getSubject(),
            $body,
            $configuration->getTo(),
            $configuration->getFrom(),
            true,
            $configuration->getReplyTo(),
            $configuration->getAddAttachments() ? $this->attachments : [],
            $configuration->getCc(),
            $configuration->getBcc(),
            $this->getPlainText($form, $configuration, $additionalData)
        );
    }

    /**
     * Upload media.
     *
     * @return mixed[]
     */
    private function uploadMedia(FormInterface $form, FormConfigurationInterface $configuration): array
    {
        $this->attachments = [];
        $mediaIds = [];

        foreach ($configuration->getFileFields() as $field => $collectionId) {
            if (!$form->has($field) || !count($form[$field]->getData())) {
                continue;
            }

            $files = $form[$field]->getData();
            $ids = [];

            if (!is_array($files)) {
                $files = [$files];
            }

            /** @var UploadedFile $file */
            foreach ($files as $file) {
                if (!$file instanceof UploadedFile) {
                    continue;
                }

                $media = $this->mediaManager->save(
                    $file,
                    $this->getMediaData($file, $form, $configuration, $collectionId),
                    null
                );

                // save attachments data for swift message
                $this->attachments[] = $file;
                $ids[] = $media->getId();
            }

            $mediaIds[$field] = $ids;
        }

        return $mediaIds;
    }

    /**
     * Map media ids.
     *
     * @param mixed $entity
     * @param int[] $mediaIds
     *
     * @return mixed
     */
    private function mapMediaIds($entity, array $mediaIds)
    {
        $accessor = new PropertyAccessor();

        foreach ($mediaIds as $key => $value) {
            $accessor->setValue($entity, $key, $value);
        }

        return $entity;
    }

    /**
     * Get media data.
     *
     * @return mixed[]
     */
    protected function getMediaData(
        UploadedFile $file,
        FormInterface $form,
        FormConfigurationInterface $configuration,
        int $collectionId
    ): array {
        return [
            'collection' => $collectionId,
            'locale' => $configuration->getLocale(),
            'title' => $file->getClientOriginalName(),
        ];
    }

    /**
     * Get plain text variant for email, overridable and customizable per form.
     *
     * @param mixed[] $additionalData
     */
    protected function getPlainText(FormInterface $form, MailConfigurationInterface $configuration, array $additionalData): string
    {
        return $this->twig->render(
            $configuration->getPlainTextTemplate(),
            array_merge(
                $configuration->getTemplateAttributes(),
                $additionalData
            )
        );
    }
}

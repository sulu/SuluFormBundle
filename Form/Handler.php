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
use Sulu\Bundle\FormBundle\Event\FormSavePostEvent;
use Sulu\Bundle\FormBundle\Event\FormSavePreEvent;
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

    /**
     * @var string
     */
    private $honeyPotStrategy;

    /**
     * @var string|null
     */
    private $honeyPotField;

    public function __construct(
        ObjectManager $entityManager,
        Mail\HelperInterface $mailHelper,
        Environment $twig,
        EventDispatcherInterface $eventDispatcher,
        MediaManager $mediaManager,
        string $honeyPotStrategy = self::HONEY_POT_STRATEGY_SPAM,
        string $honeyPotField = null
    ) {
        $this->entityManager = $entityManager;
        $this->mailHelper = $mailHelper;
        $this->twig = $twig;
        $this->eventDispatcher = $eventDispatcher;
        $this->mediaManager = $mediaManager;
        $this->attachments = [];
        $this->honeyPotStrategy = $honeyPotStrategy;
        $this->honeyPotField = $honeyPotField;
    }

    /**
     * Handle form.
     */
    public function handle(FormInterface $form, FormConfigurationInterface $configuration): bool
    {
        if (!$form->isValid()) {
            return false;
        }

        $isSpam = $this->isSpamByHoneypot($form);

        if ($isSpam && self::HONEY_POT_STRATEGY_NO_SAVE === $this->honeyPotStrategy) {
            return true; // emulate a successfully form submit
        }

        $mediaIds = $this->uploadMedia($form, $configuration);
        $this->mapMediaIds($form->getData(), $mediaIds);
        $this->save($form, $configuration);

        if ($isSpam && self::HONEY_POT_STRATEGY_NO_EMAIL === $this->honeyPotStrategy) {
            return true; // emulate a successfully form submit
        }

        $this->sendMails($form, $configuration);

        return true;
    }

    /**
     * Save form.
     */
    private function save(FormInterface $form, FormConfigurationInterface $configuration): void
    {
        $this->eventDispatcher->dispatch(
            new FormSavePreEvent(
                $form,
                $configuration
            ),
            FormSavePreEvent::NAME
        );

        if (!$configuration->getSave()) {
            return;
        }

        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(
            new FormSavePostEvent(
                $form,
                $configuration
            ),
            FormSavePreEvent::NAME
        );
    }

    private function sendMails(FormInterface $form, FormConfigurationInterface $configuration): void
    {
        if ($adminMailConfiguration = $configuration->getAdminMailConfiguration()) {
            $subjectPrefix = '';
            if ($this->isSpamByHoneypot($form)) {
                $subjectPrefix = '(SPAM) ';
            }

            $this->sendMail($form, $adminMailConfiguration, $subjectPrefix);
        }

        if ($websiteMailConfiguration = $configuration->getWebsiteMailConfiguration()) {
            $this->sendMail($form, $websiteMailConfiguration);
        }
    }

    /**
     * Send mail.
     *
     * @param FormInterface $form
     * @param MailConfigurationInterface $configuration
     * @param string $subjectPrefix
     */
    private function sendMail(FormInterface $form, MailConfigurationInterface $configuration, string $subjectPrefix = '')
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

        $subject = $configuration->getSubject();

        if ($subjectPrefix) {
            $subject = $subjectPrefix . $subject;
        }

        $this->mailHelper->sendMail(
            $subject,
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
    protected function getPlainText(FormInterface $form, MailConfigurationInterface $configuration, array $additionalData): ?string
    {
        $template = $configuration->getPlainTextTemplate();

        if (!$template) {
            return null;
        }

        return $this->twig->render(
            $template,
            array_merge(
                $configuration->getTemplateAttributes(),
                $additionalData
            )
        );
    }

    private function isSpamByHoneypot(FormInterface $form): bool
    {
        if (!$this->honeyPotField) {
            return false;
        }

        $honeypotFieldName = str_replace(' ', '_', strtolower($this->honeyPotField));

        if (!$form->has($honeypotFieldName)) {
            return false;
        }

        $honeypotField = $form->get($honeypotFieldName);

        if (!$honeypotField->getData()) {
            return false;
        }

        return true;
    }
}

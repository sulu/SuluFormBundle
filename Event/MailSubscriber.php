<?php

namespace Sulu\Bundle\FormBundle\Event;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Mail\HelperInterface as MailHelperInterface;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManager;
use Sulu\Bundle\MediaBundle\Media\Storage\StorageInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * MailSubscriber listens on event which is thrown on saving a form entry.
 */
class MailSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailHelperInterface
     */
    protected $mailHelper;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var MediaManager
     */
    protected $mediaManager;

    /**
     * @var StorageInterface
     */
    protected $storageManager;

    /**
     * @var string
     */
    protected $notifyTemplate;
    /**
     * @var string
     */
    protected $customerTemplate;

    /**
     * @param MailHelperInterface $mailHelper
     * @param EngineInterface $templating
     * @param MediaManager $mediaManager
     * @param StorageInterface $storageManager
     * @param string $notifyTemplate
     * @param string $customerTemplate
     */
    public function __construct(
        MailHelperInterface $mailHelper,
        EngineInterface $templating,
        MediaManager $mediaManager,
        StorageInterface $storageManager,
        $notifyTemplate,
        $customerTemplate
    ) {
        $this->mailHelper = $mailHelper;
        $this->templating = $templating;
        $this->mediaManager = $mediaManager;
        $this->storageManager = $storageManager;
        $this->notifyTemplate = $notifyTemplate;
        $this->customerTemplate = $customerTemplate;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            DynFormSavedEvent::NAME => 'sendMails',
        ];
    }

    /**
     * Handles the mail delivery on saving a dynamic form.
     *
     * @param DynFormSavedEvent $event
     */
    public function sendMails(DynFormSavedEvent $event)
    {
        $dynamic = $event->getDynamic();
        $form = $dynamic->form;
        $formEntity = $form->serializeForLocale($dynamic->locale, $dynamic);
        $translation = $form->getTranslation($dynamic->locale);

        if (!$translation->getDeactivateCustomerMails() && !empty($dynamic->email)) {
            $customerMail = $this->templating->render($this->customerTemplate, ['formEntity' => $formEntity]);
            $this->mailHelper->sendMail(
                $translation->getSubject(),
                $customerMail,
                $dynamic->email,
                $this->getFromAddress($translation),
                true
            );
        }

        $this->sendNotifyMail($dynamic, $form, $formEntity, $translation);
    }

    /**
     * Sends the notification mails.
     *
     * @param Dynamic $dynamic
     * @param Form $form
     * @param array $formEntity
     * @param FormTranslation $translation
     */
    protected function sendNotifyMail(Dynamic $dynamic, Form $form, $formEntity, FormTranslation $translation)
    {
        if (!$translation->getDeactivateNotifyMails()) {
            $allReceivers = $this->mailHelper->getReceiverTypes();

            // Add main receiver of form.
            $mainReceiver = $this->getNotifyToMailAddress($translation);
            if ($mainReceiver) {
                $allReceivers[MailHelperInterface::MAIL_RECEIVER_TO] = $mainReceiver;
            }

            // Add additional receivers.
            foreach ($translation->getReceivers() as $receiver) {
                if (!empty($receiver->getEmail())) {
                    $allReceivers[$receiver->getType()][$receiver->getEmail()] = $receiver->getName();
                }
            }

            $attachedMediaIds = $this->getAttachedMediaIds($form, $dynamic);
            $attachments = $this->loadAttachments($attachedMediaIds, $dynamic->locale);

            $notifyMail = $this->templating->render($this->notifyTemplate, ['formEntity' => $formEntity]);
            $this->mailHelper->sendMail(
                $translation->getSubject(),
                $notifyMail,
                $allReceivers[MailHelperInterface::MAIL_RECEIVER_TO],
                $this->getFromAddress($translation),
                true,
                null,
                $attachments,
                $allReceivers[MailHelperInterface::MAIL_RECEIVER_CC],
                $allReceivers[MailHelperInterface::MAIL_RECEIVER_BCC]
            );
        }
    }

    /**
     * Returns the sender email address.
     *
     * @param FormTranslation $translation
     *
     * @return array|null
     */
    protected function getFromAddress(FormTranslation $translation)
    {
        $fromMail = $translation->getFromEmail();
        $fromName = $translation->getFromName();

        if (!$fromMail || !$fromName) {
            return;
        }

        return [$fromMail => $fromName];
    }

    /**
     * Returns the main email address for sending notification.
     *
     * @param FormTranslation $translation
     *
     * @return string
     */
    protected function getNotifyToMailAddress(FormTranslation $translation)
    {
        $toMail = $translation->getToEmail();
        $toName = $translation->getToName();

        if (!$toMail || !$toName) {
            return;
        }

        return [$toMail => $toName];
    }

    /**
     * Returns the ids of medias which was uploaded in the form.
     *
     * @param Form $formEntity
     * @param Dynamic $dynamic
     *
     * @return array
     */
    protected function getAttachedMediaIds(Form $formEntity, Dynamic $dynamic)
    {
        $mediaIds = [];

        foreach ($formEntity->getFields() as $field) {
            if ($field->getType() === Dynamic::TYPE_ATTACHMENT) {
                $mediaIds = array_merge($mediaIds, $dynamic->getField($field->getKey()));
            }
        }

        return $mediaIds;
    }

    /**
     * Returns the files which should be attached to the mail.
     *
     * @param array $attachedMediaIds
     * @param string $locale
     *
     * @return \SplFileInfo[]
     */
    protected function loadAttachments($attachedMediaIds, $locale)
    {
        $attachments = [];

        $medias = $this->mediaManager->getByIds($attachedMediaIds, $locale);
        foreach ($medias as $media) {
            $path = $this->storageManager->load($media->getName(), $media->getVersion(), $media->getStorageOptions());
            $attachments[] = new \SplFileInfo($path);
        }

        return $attachments;
    }
}

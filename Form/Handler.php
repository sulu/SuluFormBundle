<?php

namespace L91\Sulu\Bundle\FormBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use L91\Sulu\Bundle\FormBundle\Form\Type\TypeInterface;
use L91\Sulu\Bundle\FormBundle\Mail;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Templating\EngineInterface;

class Handler implements HandlerInterface
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var FormExtensionInterface
     */
    protected $formExtension;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var CsrfTokenManagerInterface
     */
    protected $csrfTokenManager;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var array
     */
    protected $attributes;

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
     * @param FormFactoryInterface $formFactory
     * @param FormExtensionInterface $formExtension
     * @param ObjectManager $entityManager
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param Mail\HelperInterface $mailHelper
     * @param EngineInterface $templating
     * @param EventDispatcherInterface $eventDispatcher
     * @param MediaManager $mediaManager
     * @param null $logger
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        FormExtensionInterface $formExtension,
        ObjectManager $entityManager,
        CsrfTokenManagerInterface $csrfTokenManager,
        Mail\HelperInterface $mailHelper,
        EngineInterface $templating,
        EventDispatcherInterface $eventDispatcher,
        MediaManager $mediaManager,
        $logger = null
    ) {
        $this->formFactory = $formFactory;
        $this->formExtension = $formExtension;
        $this->mailHelper = $mailHelper;
        $this->entityManager = $entityManager;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->templating = $templating;
        $this->eventDispatcher = $eventDispatcher;
        $this->mediaManager = $mediaManager;
        $this->logger = $logger ? $logger : new NullLogger();

        $this->attachments = [];
    }

    /**
     * @{@inheritdoc}
     */
    public function get($name, $attributes = [])
    {
        $type = $this->formExtension->getType($name);

        if ($type instanceof TypeInterface) {
            $type->setAttributes($attributes);
        }

        return $this->formFactory->create($name);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(FormInterface $form, $attributes = [])
    {
        if (!$form->isValid()) {
            return false;
        }

        $mediaIds = [];

        if (isset($attributes['_form_type'])) {
            $type = $attributes['_form_type'];
            unset($attributes['_form_type']);
        } else {
            $type = $this->formExtension->getType($form->getName());
        }

        if ($type instanceof TypeInterface) {
            foreach ($type->getFileFields() as $field) {
                if (!$form->has($field) || !count($form[$field]->getData())) {
                    continue;
                }

                $files = $form[$field]->getData();
                $collectionId = $type->getCollectionId();
                $ids = [];

                // convert $files to array
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
                        [
                            'collection' => $collectionId,
                            'locale' => $this->getFormLocale($form),
                            'title' => $file->getClientOriginalName(),
                        ],
                        null
                    );

                    // save attachments data for swift message
                    $this->attachments[] = $file;
                    $ids[] = $media->getId();
                }

                $mediaIds[$field] = $ids;
            }
        }

        $attributes['form'] = $form;

        $this->saveForm($form, $attributes, $mediaIds);

        if ($type instanceof TypeInterface) {
            $this->sendMails($type, $attributes, $form);
        }

        return true;
    }

    /**
     * @param TypeInterface $type
     * @param array $attributes
     * @param FormInterface $form
     */
    protected function sendMails(
        TypeInterface $type,
        $attributes,
        FormInterface $form
    ) {
        $notifyMailTemplatePath = $type->getNotifyMail($form->getData());
        $customerMailTemplatePath = $type->getCustomerMail($form->getData());

        if (!$type->getNotifyDeactivateMails($form->getData())) {
            $notifyMail = $this->templating->render($notifyMailTemplatePath, $attributes);

            $this->mailHelper->sendMail(
                $type->getNotifySubject($form->getData()),
                $notifyMail,
                $type->getNotifyToMailAddress($form->getData()),
                $type->getNotifyFromMailAddress($form->getData()),
                true,
                $type->getNotifyReplyToMailAddress($form->getData()),
                $type->getNotifySendAttachments($form->getData()) ? $this->attachments : []
            );
        }

        if (!$type->getCustomerDeactivateMails($form->getData())) {
            $customerMail = $this->templating->render($customerMailTemplatePath, $attributes);

            $this->mailHelper->sendMail(
                $type->getCustomerSubject($form->getData()),
                $customerMail,
                $type->getCustomerToMailAddress($form->getData()),
                $type->getCustomerFromMailAddress($form->getData()),
                true,
                $type->getCustomerReplyToMailAddress($form->getData())
            );
        }
    }

    /**
     * @param FormInterface $form
     * @param array $attributes
     * @param array $mediaIds
     *
     * @throws \Exception
     */
    protected function saveForm(FormInterface $form, $attributes = [], $mediaIds = [])
    {
        $formData = $form->getData();

        if (is_array($formData)) {
            throw new \Exception('Form Data need to be an object!');
        } else {
            $entity = $formData;

            foreach ($mediaIds as $key => $value) {
                $setterMethod = 'set' . ucfirst($key);

                // Here to avoid a BC break
                if (method_exists($entity, $setterMethod)) {
                    $entity->$setterMethod($value);
                } else {
                    $entity->$key = $value;
                }
            }
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(
            self::EVENT_FORM_SAVED,
            new FormEvent(
                $form,
                $attributes
            )
        );
    }

    /**
     * @description Returns the correct form locale.
     * TODO What's the correct way to handle both types?
     *
     * @param FormInterface $form
     *
     * @return string
     */
    public function getFormLocale($form)
    {
        $locale = 'de';

        if ($form->has('locale')) {
            $locale = $form->get('locale')->getData();
        } elseif ($form->getData()->locale) {
            $locale = $form->getData()->locale;
        }

        return $locale;
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getToken($name)
    {
        return $this->csrfTokenManager->getToken($name)->getValue();
    }
}

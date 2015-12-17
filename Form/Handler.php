<?php

namespace L91\Sulu\Bundle\FormBundle\Form;

use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use L91\Sulu\Bundle\FormBundle\Form\Type\TypeInterface;
use L91\Sulu\Bundle\FormBundle\Mail;
use Doctrine\Common\Persistence\ObjectManager;
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
    }

    /**
     * @{@inheritdoc}
     */
    public function get($name, $attributes = array())
    {
        $type = $this->formExtension->getType($name);

        if ($type instanceof TypeInterface) {
            $type->setAttributes($attributes);
        }

        return $this->formFactory->create($name);
    }

    /**
     * @{inheritdoc}
     */
    public function handle(FormInterface $form, $attributes = array())
    {
        if (!$form->isValid()) {
            return false;
        }

        $mediaIds = [];
        if ($form->has('files')) {
            $files = $form['files']->getData();
            if (count($files)) {
                $type = $this->formExtension->getType($form->getName());
                $collectionId = $type->getCollectionId();

                $ids = [];
                /** @var UploadedFile $file */
                foreach ($form['files']->getData() as $file) {
                    if ($file instanceof UploadedFile) {
                        $media = $this->mediaManager->save(
                            $file,
                            [
                                'collection' => $collectionId,
                                'locale' => $form->get('locale')->getData(),
                                'title' => $file->getClientOriginalName(),
                            ],
                            null
                        );
                        $ids[] = $media->getId();
                    }
                }

                $mediaIds['files'] = $ids;
            }
        }

        $attributes['form'] = $form;

        $this->saveForm($form, $attributes, $mediaIds);

        $type = $this->formExtension->getType($form->getName());

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
        $attributes = array(),
        FormInterface $form
    ) {
        $notifyMailTemplatePath = $type->getNotifyMail($form->getData());
        $customerMailTemplatePath = $type->getCustomerMail($form->getData());

        if ($notifyMailTemplatePath) {
            $notifyMail = $this->templating->render($notifyMailTemplatePath, $attributes);

            $this->mailHelper->sendMail(
                $type->getNotifySubject($form->getData()),
                $notifyMail,
                $type->getNotifyToMailAddress($form->getData()),
                $type->getNotifyFromMailAddress($form->getData())
            );
        }

        if ($customerMailTemplatePath) {
            $customerMail = $this->templating->render($customerMailTemplatePath, $attributes);

            $this->mailHelper->sendMail(
                $type->getCustomerSubject($form->getData()),
                $customerMail,
                $type->getCustomerToMailAddress($form->getData()),
                $type->getCustomerFromMailAddress($form->getData())
            );
        }
    }

    /**
     * @param FormInterface $form
     * @param array $attributes
     * @param array $mediaIds
     */
    protected function saveForm(FormInterface $form, $attributes = array(), $mediaIds = array())
    {
        $formData = $form->getData();

        if (is_array($formData)) {
            $entity = new Dynamic();
            if (!empty($mediaIds) && array_key_exists('files', $mediaIds)) {
                $formData['files'] = $mediaIds['files'];
            }
            $entity->setData(json_encode($formData));
            $entity->setCreated(new \DateTime());
        } else {
            $entity = $formData;
            if (!empty($mediaIds) && array_key_exists('files', $mediaIds)) {
                $entity->setFiles($mediaIds['files']);
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
     * @param $name
     * @return string
     */
    public function getToken($name)
    {
        $intention = '';

        $type = $this->formExtension->getType($name);

        if ($type instanceof TypeInterface) {
            $intention = $type->getDefaultIntention();
        }

        if (isset($defaults['intention'])) {
            $intention = $defaults['intention'];
        }

        return $this->csrfTokenManager->refreshToken(
            $intention
        );
    }
}

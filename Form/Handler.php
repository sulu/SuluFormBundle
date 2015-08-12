<?php

namespace L91\Sulu\Bundle\FormBundle\Form;

use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use L91\Sulu\Bundle\FormBundle\Form\Type\TypeInterface;
use L91\Sulu\Bundle\FormBundle\Mail;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
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
     * @param FormFactoryInterface $formFactory
     * @param FormExtensionInterface $formExtension
     * @param ObjectManager $entityManager
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param Mail\HelperInterface $mailHelper,
     * @param EngineInterface $templating
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface $logger
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        FormExtensionInterface $formExtension,
        ObjectManager $entityManager,
        CsrfTokenManagerInterface $csrfTokenManager,
        Mail\HelperInterface $mailHelper,
        EngineInterface $templating,
        EventDispatcherInterface $eventDispatcher,
        $logger = null
    ) {
        $this->formFactory = $formFactory;
        $this->formExtension = $formExtension;
        $this->mailHelper = $mailHelper;
        $this->entityManager = $entityManager;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->mailHelper = $mailHelper;
        $this->templating = $templating;
        $this->eventDispatcher = $eventDispatcher;
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

        $attributes['form'] = $form;

        $this->saveForm($form, $attributes);

        $type = $this->formExtension->getType($form->getName());

        if ($type instanceof TypeInterface) {
            $this->sendMails($type, $attributes);
        }

        return true;
    }

    /**
     * @param TypeInterface $type
     * @param array $attributes
     */
    protected function sendMails(
        TypeInterface $type,
        $attributes = array()
    ) {
        $notifyMail = $this->templating->render($type->getNotifyMail(), $attributes);
        $customerMail = $this->templating->render($type->getCustomerMail(), $attributes);

        if ($notifyMail) {
            $this->mailHelper->sendMail(
                $type->getNotifySubject(),
                $notifyMail,
                $type->getNotifyToMailAddress(),
                $type->getNotifyFromMailAddress()
            );
        }

        if ($customerMail) {
            $this->mailHelper->sendMail(
                $type->getCustomerSubject(),
                $customerMail,
                $type->getCustomerToMailAddress(),
                $type->getCustomerFromMailAddress()
            );
        }
    }

    /**
     * @param FormInterface $form
     * @param array $attributes
     */
    protected function saveForm(FormInterface $form, $attributes = array())
    {
        $formData = $form->getData();
        if (is_array($formData)) {
            $entity = new Dynamic();
            $entity->setData(json_encode($formData));
            $entity->setCreated(new \DateTime());
        } else {
            $entity = $formData;
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

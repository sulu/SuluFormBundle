<?php

namespace Client\Bundle\FormBundle\Form;

use Client\Bundle\FormBundle\Form\Type\TypeInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\Templating\EngineInterface;

class Handler implements HandlerInterface
{
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var FormRegistryInterface
     */
    protected $formRegistry;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @param FormFactoryInterface $formFactory
     * @param FormRegistryInterface $formRegistry
     * @param ObjectManager $entityManager
     * @param EngineInterface $templating
     * @param LoggerInterface $logger
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        FormRegistryInterface $formRegistry,
        ObjectManager $entityManager,
        EngineInterface $templating,
        $logger = null
    ) {
        $this->formFactory = $formFactory;
        $this->formRegistry = $formRegistry;
        $this->logger = $logger ? $logger : new NullLogger();
        $this->entityManager = $entityManager;
        $this->templating = $templating;
    }

    /**
     * @{@inheritdoc}
     */
    public function get($name, $attributes = array())
    {
        return $this->formFactory->create(
            $name,
            array('attributes' => $attributes)
        );
    }

    /**
     * @{inheritdoc}
     */
    public function handle(FormInterface $form)
    {
        if (!$form->isValid()) {
            return false;
        }


        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();

        // TODO Email Render
        return true;
    }
}
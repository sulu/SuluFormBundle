<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Form\HandlerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    /**
     * @var BuilderInterface
     */
    protected $formBuilder;

    /**
     * @var HandlerInterface
     */
    protected $formHandler;

    /**
     * @var FormConfigurationFactory
     */
    protected $formConfigurationFactory;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * RequestListener constructor.
     *
     * @param BuilderInterface $formBuilder
     * @param HandlerInterface $formHandler
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        BuilderInterface $formBuilder,
        HandlerInterface $formHandler,
        FormConfigurationFactory $formConfigurationFactory,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->formBuilder = $formBuilder;
        $this->formHandler = $formHandler;
        $this->formConfigurationFactory = $formConfigurationFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * On Kernel request.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            // do nothing if it's not the master request
            return;
        }

        $request = $event->getRequest();

        if (!$request->isMethod('post')) {
            // do nothing if it's not a post request
            return;
        }

        try {
            /** @var FormInterface $form */
            $form = $this->formBuilder->buildByRequest($request);

            if (!$form || !$form->isSubmitted() || !$form->isValid()) {
                // do nothing when no form was found or not valid
                return;
            }
        } catch (\Exception $e) {
            // Catch all exception on build form by request
            return;
        }

        /** @var Dynamic $dynamic */
        $dynamic = $form->getData();
        $configuration = $this->formConfigurationFactory->buildByDynamic($dynamic);

        if ($this->formHandler->handle($form, $configuration)) {
            $serializedObject = $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic);
            $dynFormSavedEvent = new DynFormSavedEvent($serializedObject, $dynamic);
            $this->eventDispatcher->dispatch(DynFormSavedEvent::NAME, $dynFormSavedEvent);

            $response = new RedirectResponse('?send=true');
            $event->setResponse($response);
        }
    }
}

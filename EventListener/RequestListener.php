<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\EventListener;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Event\DynFormSavedEvent;
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
    protected $formHander;

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
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->formBuilder = $formBuilder;
        $this->formHandler = $formHandler;
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
            // don't do anything if it's not the master request
            return;
        }

        $request = $event->getRequest();

        if (!$request->isMethod('post')) {
            // don't do anything if it's not a post request
            return;
        }

        try {
            /** @var FormInterface $form */
            $form = $this->formBuilder->buildByRequest($request);

            if (!$form) {
                // do nothing when no form was found
                return;
            }
        } catch (\Exception $e) {
            // Catch all exception on build form by request

            return;
        }

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Dynamic $dynamic */
            $dynamic = $form->getData();
            $serializedObject = $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic);

            // save
            $this->formHandler->handle(
                $form,
                [
                    'formEntity' => $serializedObject,
                ]
            );

            $dynFormSavedEvent = new DynFormSavedEvent($serializedObject, $dynamic);
            $this->eventDispatcher->dispatch(DynFormSavedEvent::NAME, $dynFormSavedEvent);

            $response = new RedirectResponse('?send=true');
            $event->setResponse($response);
        }
    }
}

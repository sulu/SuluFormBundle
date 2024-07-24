<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Contracts\Service\ResetInterface;

class RequestListener implements ResetInterface
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
     * Flag set to true when an invalid form is submitted,
     * so we can set the http return code to 422.
     *
     * @var bool
     */
    protected $invalidSubmittedForm = false;

    /**
     * RequestListener constructor.
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

    public function onKernelRequest(RequestEvent $event): void
    {
        if (\method_exists($event, 'isMainRequest') ? !$event->isMainRequest() : !$event->isMasterRequest()) {
            // do nothing if it's not the master request
            return;
        }

        $request = $event->getRequest();

        if (!$request->isMethod('post')) {
            // do nothing if it's not a post request
            return;
        }

        try {
            $form = $this->formBuilder->buildByRequest($request);

            if (!$form || !$form->isSubmitted()) {
                // do nothing when no form was found or not valid
                return;
            }

            if (!$form->isValid()) {
                $this->invalidSubmittedForm = true;

                return;
            }
        } catch (\Exception $e) {
            // Catch all exception on build form by request
            return;
        }

        /** @var Dynamic $dynamic */
        $dynamic = $form->getData();
        $configuration = $this->formConfigurationFactory->buildByDynamic($dynamic);
        $dynamic->setLocale($request->getLocale()); // Need to be set to request locale for shadow pages, configuraiton will hold the original locale

        if ($this->formHandler->handle($form, $configuration)) {
            $serializedObject = $dynamic->getForm()->serializeForLocale($dynamic->getLocale(), $dynamic);
            $dynFormSavedEvent = new DynFormSavedEvent($serializedObject, $dynamic);
            $this->eventDispatcher->dispatch($dynFormSavedEvent, DynFormSavedEvent::NAME);

            $response = new RedirectResponse('?send=true');
            $event->setResponse($response);
        }
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (\method_exists($event, 'isMainRequest') ? !$event->isMainRequest() : !$event->isMasterRequest()) {
            // do nothing if it's not the master request
            return;
        }

        if ($this->invalidSubmittedForm) {
            $response = $event->getResponse();
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

            $event->setResponse($response);
        }
    }

    public function reset(): void
    {
        $this->invalidSubmittedForm = false;
    }
}

<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Controller;

use Sulu\Bundle\FormBundle\Configuration\FormConfigurationFactory;
use Sulu\Bundle\FormBundle\Csrf\DisabledCsrfTokenManager;
use Sulu\Bundle\FormBundle\Form\HandlerInterface;
use Sulu\Bundle\FormBundle\Form\Type\AbstractType;
use Sulu\Bundle\WebsiteBundle\Controller\DefaultController;
use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormRegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * @deprecated static forms are deprecated and should not longer be used
 */
class FormWebsiteController extends DefaultController
{
    /**
     * @var FormInterface|null
     */
    protected $form;

    /**
     * @var mixed[]
     */
    protected $attributes;

    public function __construct()
    {
        @\trigger_error(
            __CLASS__ . ' is deprecated and should not longer be used.',
            \E_USER_DEPRECATED
        );
    }

    public static function getSubscribedServices(): array
    {
        $subscribesServices = parent::getSubscribedServices();
        $subscribesServices['form.registry'] = FormRegistryInterface::class;
        $subscribesServices['sulu_form.configuration.form_configuration_factory'] = FormConfigurationFactory::class;
        $subscribesServices['sulu_form.handler'] = HandlerInterface::class;
        $subscribesServices['security.csrf.token_manager'] = CsrfTokenManagerInterface::class;

        return $subscribesServices;
    }

    /**
     * Form action.
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function formAction(Request $request, StructureInterface $structure, bool $preview = false, bool $partial = false): Response
    {
        // get attributes
        $attributes = $this->getAttributes([], $structure, $preview);

        $template = $structure->getKey();

        $typeClass = $this->getTypeClass($template);
        /** @var AbstractType $type */
        $type = $this->container->get('form.registry')->getType($typeClass)->getInnerType();
        $type->setAttributes($attributes);

        $this->form = $this->container->get('form.factory')->create($typeClass, [], [
            'csrf_token_manager' => new DisabledCsrfTokenManager($this->container->get('security.csrf.token_manager')),
        ]);
        $this->form->handleRequest($request);

        if ($this->form->isSubmitted()
            && $this->form->isValid()
            && $response = $this->handleFormSubmit($request, $type, $attributes)
        ) {
            // success form submit

            return $response;
        }

        return parent::indexAction($structure, $preview, $partial);
    }

    /**
     * Form only action.
     *
     * @return RedirectResponse|Response
     */
    public function onlyAction(Request $request, string $key): Response
    {
        $ajaxTemplates = $this->getParameter('sulu_form.ajax_templates');

        if (!$ajaxTemplates[$key]) {
            throw new NotFoundHttpException();
        }

        $typeClass = $this->getTypeClass($key);
        /** @var AbstractType $type */
        $type = $this->container->get('form.registry')->getType($typeClass)->getInnerType();
        $this->form = $this->container->get('form.factory')->create($typeClass);
        $this->form->handleRequest($request);

        if ($this->form->isSubmitted()
            && $this->form->isValid()
            && $response = $this->handleFormOnlySubmit($request, $type)
        ) {
            // success form submit

            return $response;
        }

        return $this->render($ajaxTemplates[$key], ['form' => $this->form->createView()]);
    }

    /**
     * Handle form submit.
     *
     * @param mixed[] $attributes
     *
     * @return JsonResponse|RedirectResponse|null
     */
    private function handleFormSubmit(Request $request, AbstractType $type, array $attributes): ?Response
    {
        // handle form submit
        $configuration = $this->container->get('sulu_form.configuration.form_configuration_factory')->buildByType(
            $type,
            $this->form->getData(),
            $request->getLocale(),
            $attributes
        );

        $success = $this->container->get('sulu_form.handler')->handle($this->form, $configuration);

        if ($success) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['send' => $success]);
            }

            return new RedirectResponse('?send=true');
        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(
                [
                    'send' => false,
                    'errors' => $this->getErrors(),
                ],
                400
            );
        }

        return null;
    }

    private function handleFormOnlySubmit(Request $request, AbstractType $type): ?RedirectResponse
    {
        // handle form submit
        $configuration = $this->container->get('sulu_form.configuration.form_configuration_factory')->buildByType(
            $type,
            $this->form->getData(),
            $request->getLocale(),
            []
        );

        if ($this->container->get('sulu_form.handler')->handle($this->form, $configuration)) {
            return new RedirectResponse('?send=true');
        }

        return null;
    }

    /**
     * Get errors.
     *
     * @return array<string, string[]>
     */
    protected function getErrors(): array
    {
        $errors = [];

        $generalErrors = [];
        /** @var FormError $error */
        foreach ($this->form->getErrors() as $error) {
            $generalErrors[] = $error->getMessage();
        }

        if (!empty($generalErrors)) {
            $errors['general'] = $generalErrors;
        }

        foreach ($this->form->all() as $field) {
            $fieldErrors = [];

            /** @var FormError $error */
            foreach ($field->getErrors() as $error) {
                $fieldErrors[] = $error->getMessage();
            }

            if (!empty($fieldErrors)) {
                $errors[$field->getName()] = $fieldErrors;
            }
        }

        return $errors;
    }

    /**
     * @param mixed[] $attributes
     * @param bool $preview
     *
     * @return mixed[]
     */
    protected function getAttributes($attributes, StructureInterface $structure = null, $preview = false)
    {
        if (null === $this->attributes) { // for performance only called once
            $this->attributes = parent::getAttributes($attributes, $structure, $preview);
        }

        if ($this->form) {
            $this->attributes['form'] = $this->form->createView();
        }

        return $this->attributes;
    }

    private function getTypeClass(string $key): string
    {
        return $this->getParameter('sulu_form.static_forms')[$key]['class'];
    }
}

<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Controller;

use Sulu\Bundle\FormBundle\Form\Type\AbstractType;
use Sulu\Bundle\WebsiteBundle\Controller\DefaultController;
use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormWebsiteController extends DefaultController
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * Form action.
     *
     * @param StructureInterface $structure
     * @param bool $preview
     * @param bool $partial
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function formAction(StructureInterface $structure, $preview = false, $partial = false)
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        // get attributes
        $attributes = $this->getAttributes([], $structure, $preview);

        $template = $structure->getKey();

        $typeClass = $this->getTypeClass($template);
        /** @var AbstractType $type */
        $type = $this->get('form.registry')->getType($typeClass);
        $type->setAttributes($attributes);

        $this->form = $this->get('form.factory')->create($typeClass);
        $this->form->handleRequest($request);

        if ($this->form->isSubmitted()
            && !$this->form->isValid()
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
     * @param Request $request
     * @param string $key
     *
     * @return RedirectResponse|Response
     *
     * @throws NotFoundHttpException
     */
    public function onlyAction(Request $request, $key)
    {
        $ajaxTemplates = $this->container->getParameter('sulu_form.ajax_templates');

        if (!$ajaxTemplates[$key]) {
            throw new NotFoundHttpException();
        }

        $typeClass = $this->getTypeClass($key);
        /** @var AbstractType $type */
        $type = $this->get('form.registry')->getType($typeClass);
        $this->form = $this->get('form.factory')->create($typeClass);
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
     * @param Request $request
     * @param AbstractType $type
     * @param array $attributes
     *
     * @return JsonResponse|RedirectResponse
     */
    private function handleFormSubmit(Request $request, $type, $attributes)
    {
        // handle form submit
        $configuration = $this->get('sulu_form.configuration.form_configuration_factory')->buildByType(
            $type,
            $this->form->getData(),
            $request->getLocale(),
            $attributes
        );

        $success = $this->get('sulu_form.handler')->handle($this->form, $configuration);

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
    }

    /**
     * Handle form only submit.
     *
     * @param Request $request
     * @param AbstractType $type
     *
     * @return RedirectResponse
     */
    private function handleFormOnlySubmit(Request $request, $type)
    {
        // handle form submit
        $configuration = $this->get('sulu_form.configuration.form_configuration_factory')->buildByType(
            $type,
            $this->form->getData(),
            $request->getLocale(),
            []
        );

        if ($this->get('sulu_form.handler')->handle($this->form, $configuration)) {
            return new RedirectResponse('?send=true');
        }
    }

    /**
     * Generates a token for the form.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function tokenAction(Request $request)
    {
        $formName = $request->get('form');
        $csrfToken = $this->get('security.csrf.token_manager')->getToken(
            $request->get('form')
        )->getValue();

        $content = $csrfToken;

        // this should be the default behaviour in future because for varnish its needed
        if ($request->get('html')) {
            $content = sprintf(
                '<input type="hidden" id="%s__token" name="%s[_token]" value="%s" />',
                $formName,
                $formName,
                $csrfToken
            );
        }

        $response = new Response($content);

        /* Deactivate Cache for this token action */
        $response->setSharedMaxAge(0);
        $response->setMaxAge(0);
        // set shared will set the request to public so it need to be done after shared max set to 0
        $response->setPrivate();
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }

    /**
     * Get errors.
     *
     * @return array
     */
    protected function getErrors()
    {
        $errors = [];

        $generalErrors = [];
        foreach ($this->form->getErrors() as $error) {
            $generalErrors[] = $error->getMessage();
        }

        if (!empty($generalErrors)) {
            $errors['general'] = $generalErrors;
        }

        foreach ($this->form->all() as $field) {
            $fieldErrors = [];

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
     * {@inheritdoc}
     */
    protected function getAttributes($attributes, StructureInterface $structure = null, $preview = false)
    {
        if (null === $this->attributes) { // for performance only called once
            $this->attributes = parent::getAttributes($attributes, $structure, $preview);
        }

        if (!empty($this->form)) {
            $this->attributes['form'] = $this->form->createView();
        }

        return $this->attributes;
    }

    /**
     * Get type class.
     *
     * @param string $key
     *
     * @return string
     */
    private function getTypeClass($key)
    {
        $staticForms = $this->getParameter('sulu_form.static_forms');

        return $staticForms[$key]['class'];
    }
}

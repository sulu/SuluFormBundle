<?php

namespace L91\Sulu\Bundle\FormBundle\Controller;

use L91\Sulu\Bundle\FormBundle\Form\HandlerInterface;
use Sulu\Bundle\WebsiteBundle\Controller\DefaultController;
use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FormWebsiteController extends DefaultController
{
    /**
     * @var \Symfony\Component\Form\Form
     */
    protected $form;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * {@inheritdoc}
     */
    public function formAction(StructureInterface $structure, $preview = false, $partial = false)
    {
        /** @var Request $request */
        $request = $this->container->get('request_stack')->getCurrentRequest();

        // get attributes
        $attributes = $this->getAttributes([], $structure, $preview);

        $this->form = $this->getFormHandler()->get($structure->getKey(), $attributes);

        if ($request->isMethod('post')) {
            $this->form->handleRequest($request);
            if ($this->getFormHandler()->handle($this->form, $attributes)) {
                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse(['send' => true]);
                }

                return new RedirectResponse('?send=true');
            } else {
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
        }

        $this->createFormBuilder();

        $response = parent::indexAction($structure, $preview, $partial);

        return $response;
    }

    /**
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
     * @param Request $request
     * @param string $key
     *
     * @return RedirectResponse|Response
     *
     * @throws NotFoundHttpException
     */
    public function onlyAction(Request $request, $key)
    {
        $ajaxTemplates = $this->container->getParameter('l91.sulu.form.ajax_templates');

        if (!$ajaxTemplates[$key]) {
            throw new NotFoundHttpException();
        }

        $this->form = $this->getFormHandler()->get($key, $request->query->all());

        if ($request->isMethod('post')) {
            $this->form->handleRequest($request);
            if ($this->getFormHandler()->handle($this->form)) {
                return new RedirectResponse('?send=true');
            }
        }

        return $this->render($ajaxTemplates[$key], ['form' => $this->form->createView()]);
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
        $csrfToken = $this->getFormHandler()->getToken(
            $request->get('form')
        );

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
     * {@inheritdoc}
     */
    protected function getAttributes($attributes, StructureInterface $structure = null, $preview = false)
    {
        if ($this->attributes === null) { // for performance only called once
            $this->attributes = parent::getAttributes($attributes, $structure, $preview);
        }

        if (!empty($this->form)) {
            $this->attributes['form'] = $this->form->createView();
        }

        return $this->attributes;
    }

    /**
     * @return HandlerInterface
     */
    protected function getFormHandler()
    {
        return $this->get('l91.sulu.form.handler');
    }
}

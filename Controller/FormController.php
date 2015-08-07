<?php

namespace L91\Sulu\Bundle\FormBundle\Controller;

use L91\Sulu\Bundle\FormBundle\Form\HandlerInterface;
use Sulu\Bundle\WebsiteBundle\Controller\DefaultController;
use Sulu\Component\Content\StructureInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormController extends DefaultController
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
        $request = $this->getRequest(); // Change to function param when Sulu Controller is updated

        // get attributes
        $attributes = $this->getAttributes(array(), $structure, $preview);

        $this->form = $this->getFormHandler()->get($structure->getKey(), $attributes);

        if ($request->isMethod('post')) {
            $this->form->handleRequest($request);
            if ($this->getFormHandler()->handle($this->form, $attributes)) {
                return new RedirectResponse('?send=true');
            }
        }

        $this->createFormBuilder();

        $response = parent::indexAction($structure, $preview, $partial);

        return $response;
    }

    /**
     * @param Request $request
     * @param string $key
     * @return RedirectResponse|Response
     */
    public function onlyAction(Request $request, $key)
    {
        $this->form = $this->getFormHandler()->get($key, $request->attributes->all());

        if ($request->isMethod('post')) {
            $this->form->handleRequest($request);
            if ($this->getFormHandler()->handle($this->form)) {
                return new RedirectResponse('?send=true');
            }
        }

        return $this->render($request->get('view'));
    }

    /**
     * Generates a token for the form
     * @param Request $request
     * @return Response
     */
    public function tokenAction(Request $request)
    {
        $response = new Response(
            $this->getFormHandler()->getToken(
                $request->get('form')
            )
        );

        /* Deactivate Cache for this token action */
        $response->setPrivate();
        $response->setMaxAge(0);
        $response->setSharedMaxAge(0);
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

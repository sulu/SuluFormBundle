<?php

namespace L91\Bundle\FormBundle\Controller;

use L91\Bundle\FormBundle\Form\HandlerInterface;
use Sulu\Bundle\WebsiteBundle\Controller\DefaultController;
use Sulu\Component\Content\StructureInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

        $this->form = $this->getFormHandler()->get($structure->getKey() . '_example', $attributes);

        if ($request->isMethod('post')) {
            $this->form->handleRequest($request);
            if ($this->getFormHandler()->handle($this->form)) {
                return new RedirectResponse('?send=true');
            }
        }

        $this->createFormBuilder();

        $response = parent::indexAction($structure, $preview, $partial);

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
        return $this->get('client_form.handler');
    }
}
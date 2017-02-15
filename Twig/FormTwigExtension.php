<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Twig;

use Sulu\Bundle\FormBundle\Form\BuilderInterface;

/**
 * Extension for content form generation.
 */
class FormTwigExtension extends \Twig_Extension
{
    /**
     * @var FormRepository
     */
    private $formBuilder;

    public function __construct(BuilderInterface $formBuilder) {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Returns an array of possible function in this extension.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('sulu_form_get_by_id', [$this, 'getFormById']),
        ];
    }

    public function getFormById($id, $type, $typeId, $locale = null, $name = 'form') {
        list($formType, $form) = $this->formBuilder->build((int)$id, $type, $typeId, $locale = null, $name = 'form');

        return $form->createView();
    }
}

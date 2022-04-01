<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Twig;

use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Symfony\Component\Form\FormView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Extension for content form generation.
 */
class FormTwigExtension extends AbstractExtension
{
    /**
     * @var BuilderInterface
     */
    private $formBuilder;

    public function __construct(BuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('sulu_form_get_by_id', [$this, 'getFormById']),
        ];
    }

    public function getFormById(int $id, string $type, string $typeId, string $locale = null, string $name = 'form'): ?FormView
    {
        $form = $this->formBuilder->build((int) $id, $type, $typeId, $locale, $name);

        if (!$form) {
            return null;
        }

        return $form->createView();
    }
}

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

class FormTwigExtension extends AbstractExtension
{
    public function __construct(
        private BuilderInterface $formBuilder,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sulu_form_get_by_id', [$this, 'getFormById']),
        ];
    }

    public function getFormById(int $id, string $type, string $typeId, ?string $locale = null, string $name = 'form'): ?FormView
    {
        $form = $this->formBuilder->build($id, $type, $typeId, $locale, $name);

        if (!$form) {
            return null;
        }

        return $form->createView();
    }
}

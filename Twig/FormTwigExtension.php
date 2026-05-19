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

use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Component\Webspace\Analyzer\RequestAnalyzerInterface;
use Symfony\Component\Form\FormView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormTwigExtension extends AbstractExtension
{
    public function __construct(
        private BuilderInterface $formBuilder,
        private RequestAnalyzerInterface $requestAnalyzer,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sulu_form_get_by_id', [$this, 'getFormById']),
            new TwigFunction('sulu_form_build', [$this, 'getFormByContent']),
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

    /**
     * @param array{entity?: Form, data?: array<string, mixed>} $formContent
     */
    public function getFormByContent(array $formContent, string $type, string $typeId, ?string $locale = null, string $name = 'form'): ?FormView
    {
        $form = $formContent['entity'] ?? null;
        if (!$form instanceof Form) {
            return null;
        }

        $formId = $form->getId();
        if (null === $formId) {
            return null;
        }

        if (null === $locale) {
            $requestLocale = $this->requestAnalyzer->getCurrentLocalization()?->getLocale();
            $locale = (null !== $requestLocale && null !== $form->getTranslation($requestLocale))
                ? $requestLocale
                : $form->getDefaultLocale();
        }

        $builtForm = $this->formBuilder->build(
            $formId,
            $type,
            $typeId,
            $locale,
            $name
        );

        return $builtForm?->createView();
    }
}

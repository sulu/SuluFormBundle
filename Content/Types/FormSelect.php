<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Content\Types;

use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\Compat\Structure\PageBridge;
use Sulu\Component\Content\Compat\Structure\StructureBridge;
use Sulu\Component\Content\SimpleContentType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * ContentType for selecting a form.
 */
class FormSelect extends SimpleContentType
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var FormRepository
     */
    private $formRepository;

    /**
     * @var BuilderInterface
     */
    private $formBuilder;

    /**
     * FormSelect constructor.
     *
     * @param string $template
     * @param FormRepository $formRepository
     * @param BuilderInterface $formBuilder
     */
    public function __construct(
        $template,
        FormRepository $formRepository,
        BuilderInterface $formBuilder
    ) {
        parent::__construct('FormSelect', '');
        $this->template = $template;
        $this->formRepository = $formRepository;
        $this->formBuilder = $formBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentData(PropertyInterface $property)
    {
        $id = (int) $property->getValue();

        if (!$id) {
            return;
        }

        if (!isset($property->getParams()['type'])) {
            throw new MissingOptionsException(
                'SuluFormBundle: The parameter "type" is missing on "form_select" content-type.',
                []
            );
        }

        $type = $property->getParams()['type']->getValue();

        /** @var PageBridge $structure */
        $structure = $property->getStructure();

        /** @var FormInterface $form */
        $form = $this->formBuilder->build(
            $id,
            $type,
            $structure->getUuid(),
            $structure->getLanguageCode(),
            $property->getName()
        );

        if (!$form) {
            $form = $this->loadShadowForm($property, $id, $type);

            if (!$form) {
                return;
            }
        }

        return $form->createView();
    }

    private function loadShadowForm(PropertyInterface $property, $id, $type)
    {
        $structure = $property->getStructure();

        if (!$structure instanceof StructureBridge) {
            return;
        }

        if (!$structure->getIsShadow()) {
            return;
        }

        return $this->formBuilder->build(
            $id,
            $type,
            $structure->getUuid(),
            $structure->getShadowBaseLanguage(),
            $property->getName()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getViewData(PropertyInterface $property)
    {
        $id = (int) $property->getValue();

        if (!$id) {
            return [];
        }

        $locale = $property->getStructure()->getLanguageCode();

        $formEntity = $this->formRepository->loadById($id, $locale);

        if (!$formEntity) {
            return [];
        }

        return [
            'entity' => $formEntity->serializeForLocale($locale),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }
}

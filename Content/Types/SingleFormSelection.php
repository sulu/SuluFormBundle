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
use Sulu\Bundle\WebsiteBundle\ReferenceStore\ReferenceStoreInterface;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\Compat\Structure\PageBridge;
use Sulu\Component\Content\Compat\Structure\StructureBridge;
use Sulu\Component\Content\SimpleContentType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * ContentType for selecting a form.
 */
class SingleFormSelection extends SimpleContentType
{
    /**
     * @var FormRepository
     */
    private $formRepository;

    /**
     * @var BuilderInterface
     */
    private $formBuilder;

    /**
     * @var ReferenceStoreInterface
     */
    private $referenceStore;

    public function __construct(
        FormRepository $formRepository,
        BuilderInterface $formBuilder,
        ReferenceStoreInterface $referenceStore
    ) {
        parent::__construct('SingleFormSelection', '');
        $this->formRepository = $formRepository;
        $this->formBuilder = $formBuilder;
        $this->referenceStore = $referenceStore;
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

        if (!isset($property->getParams()['resourceKey'])) {
            throw new MissingOptionsException(
                'SuluFormBundle: The parameter "resourceKey" is missing on "single_form_selection" content-type.',
                []
            );
        }

        $resourceKey = $property->getParams()['resourceKey']->getValue();

        /** @var PageBridge $structure */
        $structure = $property->getStructure();

        /** @var FormInterface $form */
        $form = $this->formBuilder->build(
            $id,
            $resourceKey,
            $structure->getUuid(),
            $structure->getLanguageCode(),
            $property->getName()
        );

        if (!$form) {
            $form = $this->loadShadowForm($property, $id, $resourceKey);

            if (!$form) {
                return;
            }
        }

        $this->referenceStore->add($id);

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
}

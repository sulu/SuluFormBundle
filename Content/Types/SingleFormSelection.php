<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
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
use Symfony\Component\Form\FormView;
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
     * @return FormView|null
     */
    public function getContentData(PropertyInterface $property)
    {
        $id = (int) $property->getValue();

        if (!$id) {
            return null;
        }

        if (!isset($property->getParams()['resourceKey'])) {
            throw new MissingOptionsException('SuluFormBundle: The parameter "resourceKey" is missing on "single_form_selection" content-type.', []);
        }

        /** @var string $resourceKey */
        $resourceKey = $property->getParams()['resourceKey']->getValue();

        /** @var PageBridge $structure */
        $structure = $property->getStructure();

        $form = $this->formBuilder->build(
            $id,
            $resourceKey,
            (string) $structure->getUuid(),
            $structure->getLanguageCode(),
            $property->getName()
        );

        if (!$form) {
            $form = $this->loadShadowForm($property, $id, $resourceKey);

            if (!$form) {
                return null;
            }
        }

        $this->referenceStore->add($id);

        return $form->createView();
    }

    private function loadShadowForm(PropertyInterface $property, int $id, string $type): ?FormInterface
    {
        $structure = $property->getStructure();

        if (!$structure instanceof StructureBridge) {
            return null;
        }

        if (!$structure->getIsShadow()) {
            return null;
        }

        return $this->formBuilder->build(
            $id,
            $type,
            (string) $structure->getUuid(),
            $structure->getShadowBaseLanguage(),
            $property->getName()
        );
    }

    /**
     * @return mixed[]
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

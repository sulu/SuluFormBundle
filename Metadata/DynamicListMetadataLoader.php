<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Metadata;

use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\FieldMetadata;
use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\ListMetadata;
use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\ListMetadataLoaderInterface;
use Sulu\Bundle\AdminBundle\Metadata\MetadataInterface;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\ListBuilder\DynamicListFactory;
use Sulu\Bundle\FormBundle\Manager\FormManager;
use Symfony\Contracts\Translation\TranslatorInterface;

class DynamicListMetadataLoader implements ListMetadataLoaderInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var FormManager
     */
    private $formManager;

    /**
     * @var DynamicListFactory
     */
    private $dynamicListFactory;

    public function __construct(
        TranslatorInterface $translator,
        FormManager $formManager,
        DynamicListFactory $dynamicListFactory
    ) {
        $this->translator = $translator;
        $this->formManager = $formManager;
        $this->dynamicListFactory = $dynamicListFactory;
    }

    public function getMetadata(string $key, string $locale, array $metadataOptions): ?MetadataInterface
    {
        if (0 !== \strcmp('form_data', $key)) {
            return null;
        }

        $list = new ListMetadata();

        $form = $this->getForm($metadataOptions, $locale);
        if (!$form) {
            return null;
        }

        $fieldDescriptors = $this->dynamicListFactory->getFieldDescriptors($form, $locale);
        foreach ($fieldDescriptors as $fieldDescriptor) {
            $field = new FieldMetadata($fieldDescriptor->getName());
            $field->setLabel($this->translator->trans($fieldDescriptor->getTranslation(), [], 'admin', $locale));
            $field->setType($fieldDescriptor->getType());
            $field->setVisibility($fieldDescriptor->getVisibility());
            $field->setSortable($fieldDescriptor->getSortable());

            $list->addField($field);
        }

        $list->setCacheable(false);

        return $list;
    }

    /**
     * @param mixed[] $metadataOptions
     */
    private function getForm(array $metadataOptions, string $locale): ?Form
    {
        if (!\array_key_exists('id', $metadataOptions)) {
            return null;
        }
        $entity = $this->formManager->findById($metadataOptions['id'], $locale);

        return $entity;
    }
}

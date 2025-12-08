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
use Sulu\Bundle\FormBundle\Admin\ListBuilder\DynamicListFactoryInterface;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Manager\FormManager;
use Symfony\Contracts\Translation\TranslatorInterface;

class DynamicListMetadataLoader implements ListMetadataLoaderInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private FormManager $formManager,
        private DynamicListFactoryInterface $dynamicListFactory
    ) {
    }

    public function getMetadata(string $key, string $locale, array $metadataOptions): ?MetadataInterface
    {
        if ('form_data' !== $key) {
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

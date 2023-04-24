<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\ListBuilder;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Exception\BuilderNotFoundException;
use Sulu\Component\Rest\ListBuilder\FieldDescriptor;
use Sulu\Component\Rest\ListBuilder\FieldDescriptorInterface;

/**
 * Create FieldDescription from a form entity.
 */
class DynamicListFactory implements DynamicListFactoryInterface
{
    /**
     * @var string
     */
    protected $defaultBuilder;

    /**
     * @var array<string, DynamicListBuilderInterface>
     */
    protected $builders;

    public function __construct(string $defaultBuilder)
    {
        $this->defaultBuilder = $defaultBuilder;
    }

    public function getFieldDescriptors(Form $form, string $locale): array
    {
        $fieldDescriptors = [];

        $fieldDescriptors['id'] = new FieldDescriptor(
            'id',
            'sulu_form.id',
            FieldDescriptorInterface::VISIBILITY_NO,
            '',
            'string'
        );

        foreach ($form->getFields() as $field) {
            if (\in_array($field->getType(), Dynamic::$HIDDEN_TYPES)) {
                continue;
            }

            $title = '';
            $translation = $field->getTranslation($locale, false, true);

            if ($translation) {
                $title = $translation->getShortTitle() ?: \strip_tags($translation->getTitle());
            }

            $fieldDescriptors[$field->getKey()] = new FieldDescriptor(
                $field->getKey(),
                $title,
                FieldDescriptorInterface::VISIBILITY_YES,
                FieldDescriptorInterface::SEARCHABILITY_NEVER,
                'string',
                false
            );
        }

        $fieldDescriptors['created'] = new FieldDescriptor(
            'created',
            'sulu_admin.created',
            FieldDescriptorInterface::VISIBILITY_YES,
            FieldDescriptorInterface::SEARCHABILITY_NEVER,
            'datetime'
        );

        return $fieldDescriptors;
    }

    public function build(array $dynamics, string $locale, string $builder = 'default'): array
    {
        $entries = [];

        foreach ($dynamics as $dynamic) {
            foreach ($this->getBuilder($builder)->build($dynamic, $locale) as $entry) {
                $entries[] = $entry;
            }
        }

        return $entries;
    }

    public function add(DynamicListBuilderInterface $builder, string $alias): void
    {
        $this->builders[$alias] = $builder;
    }

    protected function getBuilder(?string $alias = null): DynamicListBuilderInterface
    {
        if (!$alias || 'default' === $alias) {
            $alias = $this->defaultBuilder;
        }

        if (!isset($this->builders[$alias])) {
            throw new BuilderNotFoundException($alias);
        }

        return $this->builders[$alias];
    }
}

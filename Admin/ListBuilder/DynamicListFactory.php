<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Admin\ListBuilder;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Exception\BuilderNotFoundException;
use Sulu\Component\Rest\ListBuilder\FieldDescriptor;
use Sulu\Component\Rest\ListBuilder\FieldDescriptorInterface;

class DynamicListFactory implements DynamicListFactoryInterface
{
    /**
     * @var array<string, DynamicListBuilderInterface>
     */
    protected array $builders;

    /**
     * @param array<string, DynamicListBuilderInterface> $builders
     */
    public function __construct(
        protected string $defaultBuilder,
        iterable $builders
    ) {
        $this->builders = [...$builders];
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

    protected function getBuilder(?string $alias = null): DynamicListBuilderInterface
    {
        if (($alias ?? 'default') === 'default') {
            $alias = $this->defaultBuilder;
        }

        if (!\array_key_exists($alias, $this->builders)) {
            throw new BuilderNotFoundException($alias, \array_keys($this->builders));
        }

        return $this->builders[$alias];
    }
}

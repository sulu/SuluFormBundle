<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Provider;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineFieldDescriptor;
use Sulu\Component\Rest\ListBuilder\FieldDescriptorInterface;

class DynamicProvider implements ListProviderInterface
{
    public function getFieldDescriptors(string $webspace, string $locale, string $uuid): array
    {
        @\trigger_error(
            __METHOD__ . '() use the new dynamic list provider.',
            \E_USER_DEPRECATED
        );

        $fieldDescriptors = [
            'id' => $this->createFieldDescriptor('id', '', 'public.id', FieldDescriptorInterface::VISIBILITY_NO),
            'uuid' => $this->createFieldDescriptor('uuid', '', 'uuid', FieldDescriptorInterface::VISIBILITY_NO),
            'webspaceKey' => $this->createFieldDescriptor('webspaceKey', '', 'webspaceKey', FieldDescriptorInterface::VISIBILITY_NO),
            'locale' => $this->createFieldDescriptor('locale', '', 'locale'),
            'firstName' => $this->createFieldDescriptor('firstName'),
            'lastName' => $this->createFieldDescriptor('lastName'),
            'email' => $this->createFieldDescriptor('email'),
            'phone' => $this->createFieldDescriptor('phone'),
            'street' => $this->createFieldDescriptor('street'),
            'zip' => $this->createFieldDescriptor('zip'),
            'city' => $this->createFieldDescriptor('city'),
            'state' => $this->createFieldDescriptor('state'),
            'country' => $this->createFieldDescriptor('country'),
            'function' => $this->createFieldDescriptor('function'),
            'company' => $this->createFieldDescriptor('company'),
            'created' => $this->createFieldDescriptor('created', 'date', 'public.created'),
        ];

        return $fieldDescriptors;
    }

    protected function createFieldDescriptor(string $name, string $type = '', string $translationKey = '', string $visibility = FieldDescriptorInterface::VISIBILITY_YES): DoctrineFieldDescriptor
    {
        if (!$translationKey) {
            $translationKey = 'sulu_form.type.' . \strtolower($name);
        }

        return new DoctrineFieldDescriptor(
            $name,
            $name,
            Dynamic::class,
            $translationKey,
            [],
            $visibility,
            $type
        );
    }

    public function getEntityName(string $webspace, string $locale, string $uuid): string
    {
        return Dynamic::class;
    }
}

<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Provider;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineFieldDescriptor;

class DynamicProvider implements ListProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFieldDescriptors($webspace, $locale, $uuid)
    {
        @trigger_error(
            __METHOD__ . '() use the new dynamic list provider.',
            E_USER_DEPRECATED
        );

        $fieldDescriptors = [
            'id' => $this->createFieldDescriptor('id', '', 'public.id'),
            'uuid' => $this->createFieldDescriptor('uuid', '', 'uuid', true),
            'webspaceKey' => $this->createFieldDescriptor('webspaceKey', '', 'webspaceKey', true),
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

    /**
     * @param string $name
     * @param string $type
     * @param string $translationKey
     * @param bool $disabled
     *
     * @return DoctrineFieldDescriptor
     */
    protected function createFieldDescriptor($name, $type = '', $translationKey = '', $disabled = false)
    {
        if (!$translationKey) {
            $translationKey = 'sulu_form.type.' . strtolower($name);
        }

        return new DoctrineFieldDescriptor(
            $name,
            $name,
            Dynamic::class,
            $translationKey,
            [],
            $disabled,
            false,
            $type
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityName($webspace, $locale, $uuid)
    {
        return Dynamic::class;
    }
}

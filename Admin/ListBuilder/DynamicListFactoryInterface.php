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
use Sulu\Component\Rest\ListBuilder\FieldDescriptor;

interface DynamicListFactoryInterface
{
    /**
     * Get field descriptors.
     *
     * @return FieldDescriptor[]
     */
    public function getFieldDescriptors(Form $form, string $locale): array;

    /**
     * Build list.
     *
     * @param Dynamic[] $dynamics
     *
     * @return string[]
     */
    public function build(array $dynamics, string $locale, string $builder = 'default'): array;
}

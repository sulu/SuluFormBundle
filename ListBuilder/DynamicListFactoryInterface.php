<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace L91\Sulu\Bundle\FormBundle\ListBuilder;

use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use L91\Sulu\Bundle\FormBundle\Entity\Form;

/**
 * Create FieldDescription from a form entity.
 */
interface DynamicListFactoryInterface
{
    /**
     * Get field descriptors.
     *
     * @param Form $form
     * @param $locale
     *
     * @return mixed
     */
    public function getFieldDescriptors(Form $form, $locale);

    /**
     * Build list.
     *
     * @param Dynamic[] $dynamics
     * @param string $locale
     * @param string $builder
     *
     * @return array
     */
    public function build($dynamics, $locale, $builder = 'default');

    /**
     * Add a dynamic list builder.
     *
     * @param DynamicListBuilderInterface $builder
     * @param string $alias
     */
    public function add(DynamicListBuilderInterface $builder, $alias);
}

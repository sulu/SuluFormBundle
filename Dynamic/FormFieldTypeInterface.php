<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic;

use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Defines the form type implementation.
 */
interface FormFieldTypeInterface
{
    /**
     * Returns configuration ob backend form type.
     */
    public function getConfiguration(): FormFieldTypeConfiguration;

    /**
     * Builds the form input for frontend.
     *
     * @param mixed[] $options
     */
    public function build(FormBuilderInterface $builder, FormField $field, string $locale, array $options): void;

    /**
     * Return the default value.
     *
     * @return mixed
     */
    public function getDefaultValue(FormField $field, string $locale);
}

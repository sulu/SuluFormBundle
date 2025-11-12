<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * The Attachment form field type.
 */
class AttachmentType implements FormFieldTypeInterface
{
    use SimpleTypeTrait;

    public function getConfiguration(): FormFieldTypeConfiguration
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.attachment',
            __DIR__ . '/../../Resources/config/form-fields/field_attachment.xml',
            'special'
        );
    }

    public function build(FormBuilderInterface $builder, FormField $field, string $locale, array $options): void
    {
        $type = FileType::class;
        $options['mapped'] = false;
        $allConstraints = [];

        // Mime Types Filter.
        $mimeTypes = [];

        $translation = $field->getTranslation($locale);
        if (\is_array($translation->getOption('type'))) {
            foreach ($translation->getOption('type') as $attachmentType) {
                $mimeTypes[] = $attachmentType . '/*';
            }
        }

        if (!empty($mimeTypes)) {
            $options['attr']['accept'] = \implode(',', $mimeTypes);
        }

        // File Constraint.
        if ($translation->getOption('type') === ['image']) {
            $fileConstraint = new Image();
        } else {
            $fileConstraint = new File(['mimeTypes' => $mimeTypes]);
        }

        $allConstraints[] = $fileConstraint;

        // Required for Files.
        if ($field->getRequired()) {
            $allConstraints[] = new NotBlank();
        }

        // File Constraint.
        $options['constraints'][] = new All(['constraints' => $allConstraints]);

        // Max File Constraint.
        if ($fileMax = (int) $translation->getOption('max')) {
            $options['constraints'][] = new Count([
                'max' => $fileMax,
            ]);

            // @deprecated remove when a new major is release as max is not supported by input[type=file]
            $options['attr']['max'] = $fileMax;
            $options['attr']['data-max'] = $fileMax;
        }

        $options['multiple'] = true;
        $builder->add($field->getKey(), $type, $options);
    }
}

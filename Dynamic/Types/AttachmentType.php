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
use Symfony\Component\Validator\Constraint;
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

    /**
     * @param FormBuilderInterface<mixed> $builder
     * @param array<string, mixed> $options
     */
    public function build(FormBuilderInterface $builder, FormField $field, string $locale, array $options): void
    {
        $type = FileType::class;
        $options['mapped'] = false;
        /** @var array<Constraint> $allConstraints */
        $allConstraints = [];

        // Mime Types Filter.
        $mimeTypes = [];

        $translation = $field->getTranslation($locale);
        if (!$translation) {
            return;
        }

        $attachmentTypes = $translation->getOption('type');
        if (\is_array($attachmentTypes)) {
            foreach ($attachmentTypes as $attachmentType) {
                if (\is_string($attachmentType)) {
                    $mimeTypes[] = $attachmentType . '/*';
                }
            }
        }

        $attr = \is_array($options['attr'] ?? null) ? $options['attr'] : [];

        if (!empty($mimeTypes)) {
            $attr['accept'] = \implode(',', $mimeTypes);
        }

        // File Constraint.
        if (['image'] === $attachmentTypes) {
            $fileConstraint = new Image();
        } else {
            $fileConstraint = new File(['mimeTypes' => $mimeTypes]);
        }

        $allConstraints[] = $fileConstraint;

        // Required for Files.
        if ($field->getRequired()) {
            $allConstraints[] = new NotBlank();
        }

        $constraints = \is_array($options['constraints'] ?? null) ? $options['constraints'] : [];

        // File Constraint.
        /* @phpstan-ignore argument.type */
        $constraints[] = new All(['constraints' => $allConstraints]);

        // Max File Constraint.
        $maxOption = $translation->getOption('max');
        if (\is_numeric($maxOption) && $fileMax = (int) $maxOption) {
            $constraints[] = new Count([
                'max' => $fileMax,
            ]);

            $attr['data-max'] = $fileMax;
        }

        $options['attr'] = $attr;
        $options['constraints'] = $constraints;
        $options['multiple'] = true;
        $builder->add($field->getKey(), $type, $options);
    }
}

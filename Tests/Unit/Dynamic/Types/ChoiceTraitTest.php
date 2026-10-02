<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Unit\Dynamic\Types;

use PHPUnit\Framework\TestCase;
use Sulu\Bundle\FormBundle\Dynamic\Types\DropdownMultiple;
use Sulu\Bundle\FormBundle\Dynamic\Types\RadioButtonsType;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Symfony\Component\Form\FormBuilderInterface;

class ChoiceTraitTest extends TestCase
{
    public function testOptionalRadioButtonsGetTheNoChoiceEntry(): void
    {
        $options = $this->buildOptions(new RadioButtonsType(), ['required' => false]);

        $this->assertSame('sulu_form.no_choice', $options['placeholder']);
        $this->assertSame('messages', $options['translation_domain']);
    }

    public function testRequiredRadioButtonsKeepNoPlaceholder(): void
    {
        $options = $this->buildOptions(new RadioButtonsType(), ['required' => true]);

        $this->assertArrayNotHasKey('placeholder', $options);
    }

    public function testConfiguredPlaceholderWins(): void
    {
        $options = $this->buildOptions(
            new RadioButtonsType(),
            ['required' => false, 'attr' => ['placeholder' => 'Pick one']]
        );

        $this->assertSame('Pick one', $options['placeholder']);
        $this->assertArrayNotHasKey('translation_domain', $options);
    }

    public function testMultipleChoiceKeepsNoPlaceholder(): void
    {
        $options = $this->buildOptions(new DropdownMultiple(), ['required' => false]);

        $this->assertArrayNotHasKey('placeholder', $options);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    private function buildOptions(object $type, array $options): array
    {
        $translation = new FormFieldTranslation();
        $translation->setLocale('en');
        $translation->setOptions(['choices' => "first\nsecond"]);

        $field = new FormField();
        $field->setKey('choice');
        $field->addTranslation($translation);
        $translation->setField($field);

        $builtOptions = [];
        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->method('add')->willReturnCallback(
            function(string $name, ?string $formType, array $addedOptions) use (&$builtOptions, $builder) {
                $builtOptions = $addedOptions;

                return $builder;
            }
        );

        $type->build($builder, $field, 'en', $options);

        return $builtOptions;
    }
}

<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Component\Webspace\Manager\WebspaceManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FormGeneratorCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var WebspaceManagerInterface
     */
    private $webspaceManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        WebspaceManagerInterface $webspaceManager
    ) {
        parent::__construct('sulu:form:generate-form');
        $this->entityManager = $entityManager;
        $this->webspaceManager = $webspaceManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Generates a form with all basic form types');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $form = $this->loadTestForm() ?: new Form();

        /** @var non-empty-array<string> $locales */
        $locales = $this->webspaceManager->getAllLocales();
        $form->setDefaultLocale(\current($locales));

        foreach ($locales as $locale) {
            $formTranslation = $form->getTranslation($locale, true);
            $formTranslation->setForm($form);
            $formTranslation->setLocale($locale);
            $formTranslation->setTitle('Test Form');
        }

        $fields = [
            [
                'type' => 'salutation',
                'width' => 'half',
            ],
            [
                'type' => 'spacer',
                'width' => 'half',
            ],
            [
                'type' => 'title',
                'width' => 'half',
            ],
            [
                'type' => 'spacer',
                'width' => 'half',
            ],
            [
                'type' => 'firstName',
                'width' => 'half',
                'required' => true,
            ],
            [
                'type' => 'lastName',
                'width' => 'half',
                'required' => true,
            ],
            [
                'type' => 'street',
                'width' => 'half',
            ],
            [
                'type' => 'spacer',
                'width' => 'half',
            ],
            [
                'type' => 'zip',
                'width' => 'half',
            ],
            [
                'type' => 'city',
                'width' => 'half',
            ],
            [
                'type' => 'state',
                'width' => 'half',
            ],
            [
                'type' => 'country',
                'width' => 'half',
            ],
            [
                'type' => 'headline',
            ],
            [
                'type' => 'freeText',
            ],
            [
                'type' => 'function',
                'width' => 'half',
            ],
            [
                'type' => 'company',
                'width' => 'half',
            ],
            [
                'type' => 'fax',
                'width' => 'half',
            ],
            [
                'type' => 'phone',
                'width' => 'half',
            ],
            [
                'type' => 'email',
                'width' => 'half',
                'required' => true,
            ],
            [
                'type' => 'spacer',
                'width' => 'half',
            ],
            [
                'type' => 'attachment',
            ],
            [
                'type' => 'radioButtons',
                'options' => [
                    'choices' => $this->getChoices(),
                ],
            ],
            [
                'type' => 'checkboxMultiple',
                'options' => [
                    'choices' => $this->getChoices(),
                ],
            ],
            [
                'type' => 'dropdown',
                'options' => [
                    'choices' => $this->getChoices(),
                ],
            ],
            [
                'type' => 'dropdownMultiple',
                'options' => [
                    'choices' => $this->getChoices(),
                ],
            ],
            [
                'type' => 'checkbox',
            ],
            [
                'type' => 'text',
            ],
            [
                'type' => 'textarea',
            ],
        ];

        $existFieldKeys = [];
        foreach ($fields as $orderNumber => $field) {
            if (!isset($existFieldKeys[$field['type']])) {
                $existFieldKeys[$field['type']] = 0;
            }

            ++$existFieldKeys[$field['type']];

            $fieldKey = $field['type'];

            if (1 !== $existFieldKeys[$field['type']]) {
                $fieldKey .= $existFieldKeys[$field['type']];
            }

            $this->addField(
                $form,
                $locales,
                $field['type'],
                $fieldKey,
                $orderNumber,
                $field['width'] ?? 'full',
                $field['required'] ?? false,
                $field['options'] ?? []
            );
        }

        $this->entityManager->persist($form);
        $this->entityManager->flush();

        $output->writeln('A form called "Test Form" has been successfully created/updated.');

        return 0;
    }

    /**
     * @param non-empty-array<string> $locales
     * @param mixed[] $options
     */
    private function addField(
        Form $form,
        array $locales,
        string $fieldType,
        string $fieldKey,
        int $orderNumber,
        string $width = 'full',
        bool $required = false,
        array $options = []
    ): void {
        $formField = $form->getField($fieldKey) ?: new FormField();
        $formField->setForm($form);
        $formField->setDefaultLocale(\current($locales));
        $formField->setRequired($required);
        $formField->setType($fieldType);
        $formField->setWidth($width);
        $formField->setOrder($orderNumber);
        $formField->setKey($fieldKey);

        foreach ($locales as $locale) {
            $formFieldTranslation = $formField->getTranslation($locale, true);
            $formFieldTranslation->setTitle(\ucfirst($fieldType));
            $formFieldTranslation->setOptions($options);
        }

        $this->entityManager->persist($formField);
    }

    private function loadTestForm(): ?Form
    {
        try {
            $queryBuilder = $this->entityManager->createQueryBuilder()
                ->from(Form::class, 'form')
                ->innerJoin('form.translations', 'translation')
                ->select('form');

            $queryBuilder
                ->where($queryBuilder->expr()->eq('translation.title', ':title'))
                ->setParameter('title', 'Test Form');

            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    private function getChoices(): string
    {
        return
            'Choice 1' . \PHP_EOL .
            'Choice 2' . \PHP_EOL .
            'Choice 3' . \PHP_EOL .
            'Choice 4' . \PHP_EOL .
            'Choice 5' . \PHP_EOL .
            'Choice 6' . \PHP_EOL .
            'Choice 7' . \PHP_EOL
        ;
    }
}

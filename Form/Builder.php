<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form;

use Sulu\Bundle\FormBundle\Csrf\DisabledCsrfTokenManager;
use Sulu\Bundle\FormBundle\Dynamic\Checksum;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Form\Type\DynamicFormType;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPoolInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Builds a dynamic form.
 */
class Builder implements BuilderInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private FormFieldTypePool $formFieldTypePool,
        private TitleProviderPoolInterface $titleProviderPool,
        private FormRepository $formRepository,
        private FormFactory $formFactory,
        private Checksum $checksum,
        private CsrfTokenManagerInterface $csrfTokenManager,
        private bool $csrfProtection = false
    ) {
    }

    public function buildByRequest(Request $request): ?FormInterface
    {
        foreach ($request->request->all() as $key => $parameters) {
            if (0 === \strpos($key, 'dynamic_')) {
                if (!\is_array($parameters)
                    || !\is_string($parameters['checksum'] ?? null)
                    || !\is_string($parameters['type'] ?? null)
                    || !\is_string($parameters['formId'] ?? null)
                    || !\is_string($parameters['formName'] ?? null)
                    || !\is_string($parameters['typeId'] ?? null)
                ) {
                    continue;
                }

                $formNameParts = \explode('dynamic_', $key, 2);
                $checksumCheck = $this->checksum->check(
                    $parameters['checksum'],
                    $parameters['type'],
                    $parameters['typeId'],
                    (int) $parameters['formId'],
                    $parameters['formName']
                );

                if (!isset($formNameParts[1])) {
                    continue;
                }

                if (!$checksumCheck) {
                    throw new HttpException(400, 'SuluFormBundle: Checksum not valid!');
                }

                $locale = $request->getLocale();
                if (isset($parameters['locale']) && \is_string($parameters['locale'])) {
                    $locale = $parameters['locale'];
                }

                return $this->build(
                    (int) $parameters['formId'],
                    $parameters['type'],
                    $parameters['typeId'],
                    $locale,
                    $parameters['formName']
                );
            }
        }

        return null;
    }

    /**
     * Returns formType and the built form.
     */
    public function build(int $id, string $type, string $typeId, ?string $locale = null, string $name = 'form'): ?FormInterface
    {
        $request = $this->requestStack->getCurrentRequest();

        // Load Form entity
        $formEntity = $this->loadFormEntity($id, $locale);

        if (!$formEntity) {
            return null;
        }

        $webspaceKey = $this->getWebspaceKey();

        // Create Form
        $form = $this->createForm(
            $name,
            $type,
            $typeId,
            $locale,
            $formEntity,
            $webspaceKey
        );

        // Handle request
        $form->handleRequest($request);

        return $form;
    }

    private function createForm(
        string $name,
        string $type,
        string $typeId,
        string $locale,
        Form $formEntity,
        string $webspaceKey,
    ): FormInterface {
        $defaults = $this->getDefaults($formEntity, $locale);
        $typeName = $this->titleProviderPool->get($type)->getTitle($typeId, $locale);

        $recaptchaFields = $formEntity->getFieldsByType('recaptcha');
        $csrfTokenProtection = $this->csrfProtection;

        if (\count($recaptchaFields)) {
            $csrfTokenProtection = false;
        }

        return $this->formFactory->createNamed(
            'dynamic_' . $name . $formEntity->getId(),
            DynamicFormType::class,
            new Dynamic($type, $typeId, $locale, $formEntity, $defaults, $webspaceKey, $typeName),
            [
                'formEntity' => $formEntity,
                'locale' => $locale,
                'type' => $type,
                'typeId' => $typeId,
                'csrf_protection' => $csrfTokenProtection,
                'name' => $name,
                'block_name' => 'dynamic_' . $name,
                'csrf_token_manager' => new DisabledCsrfTokenManager($this->csrfTokenManager),
            ]
        );
    }

    /**
     * Load Form entity.
     */
    private function loadFormEntity(int $id, string $locale): ?Form
    {
        $formEntity = $this->formRepository->loadById($id, $locale);
        $translation = $formEntity?->getTranslation($locale);

        if (null === $translation) {
            // No translation for this locale exists
            return null;
        }

        return $formEntity;
    }

    /**
     * Get defaults.
     *
     * @return mixed[]
     */
    private function getDefaults(Form $formEntity, string $locale): array
    {
        // set Defaults
        $defaults = [];

        foreach ($formEntity->getFields() as $field) {
            $fieldTranslation = $field->getTranslation($locale);

            if ($fieldTranslation && $fieldTranslation->getDefaultValue()) {
                $value = $this->formFieldTypePool->get($field->getType())->getDefaultValue($field, $locale);
                $defaults[$field->getKey()] = $value;
            }
        }

        return $defaults;
    }

    private function getWebspaceKey(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        $webspaceKey = null;

        $suluMetadata = $request->attributes->get('_sulu');
        if ($suluMetadata->getAttribute('webspace')) {
            $webspaceKey = $suluMetadata->getAttribute('webspace')->getKey();
        }

        return $webspaceKey;
    }
}

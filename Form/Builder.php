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
    /**
     * @var FormInterface[]
     */
    private $cache = [];

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var FormFieldTypePool
     */
    protected $formFieldTypePool;

    /**
     * @var TitleProviderPoolInterface
     */
    protected $titleProviderPool;

    /**
     * @var FormRepository
     */
    protected $formRepository;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var Checksum
     */
    protected $checksum;

    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    /**
     * @var bool
     */
    private $csrfProtection;

    public function __construct(
        RequestStack $requestStack,
        FormFieldTypePool $formFieldTypePool,
        TitleProviderPoolInterface $titleProviderPool,
        FormRepository $formRepository,
        FormFactory $formFactory,
        Checksum $checksum,
        CsrfTokenManagerInterface $csrfTokenManager,
        bool $csrfProtection = false
    ) {
        $this->requestStack = $requestStack;
        $this->formFieldTypePool = $formFieldTypePool;
        $this->titleProviderPool = $titleProviderPool;
        $this->formRepository = $formRepository;
        $this->formFactory = $formFactory;
        $this->checksum = $checksum;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->csrfProtection = $csrfProtection;
    }

    public function buildByRequest(Request $request): ?FormInterface
    {
        foreach ($request->request->all() as $key => $parameters) {
            if (0 === \strpos($key, 'dynamic_')) {
                $formNameParts = \explode('dynamic_', $key, 2);
                $checksumCheck = $this->checksum->check(
                    $parameters['checksum'],
                    $parameters['type'],
                    $parameters['typeId'],
                    $parameters['formId'],
                    $parameters['formName']
                );

                if (!isset($formNameParts[1])) {
                    continue;
                }

                if (!$checksumCheck) {
                    throw new HttpException(400, 'SuluFormBundle: Checksum not valid!');
                }

                if (!isset($parameters['type'])
                    || !isset($parameters['formId'])
                    || !isset($parameters['formName'])
                    || !isset($parameters['typeId'])
                ) {
                    continue;
                }

                $locale = $request->getLocale();
                if (isset($parameters['locale'])) {
                    $locale = $parameters['locale'];
                }

                return $this->build(
                    $parameters['formId'],
                    $parameters['type'],
                    $parameters['typeId'],
                    $locale,
                    $parameters['formName']
                );
            }
        }

        return null;
    }

    public function build(int $id, string $type, string $typeId, ?string $locale = null, string $name = 'form'): ?FormInterface
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$locale) {
            $locale = $request->getLocale();
        }

        // Check if form was builded before and return the cached form.
        $key = $this->getKey($id, $type, $typeId, $locale, $name);

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = $this->buildForm($id, $type, $typeId, $locale, $name);
        }

        return $this->cache[$key];
    }

    /**
     * Returns formType and the built form.
     */
    protected function buildForm(int $id, string $type, string $typeId, string $locale, string $name): ?FormInterface
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

    private function getKey(int $id, string $type, string $typeId, string $locale, string $name): string
    {
        return \implode('__', \func_get_args());
    }

    private function createForm(string $name, string $type, string $typeId, string $locale, Form $formEntity, string $webspaceKey): FormInterface
    {
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

        if (!$formEntity) {
            return null;
        }

        $translation = $formEntity->getTranslation($locale);

        if (!$translation) {
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

        if ($request->get('_sulu')) {
            if ($request->get('_sulu')->getAttribute('webspace')) {
                $webspaceKey = $request->get('_sulu')->getAttribute('webspace')->getKey();
            }
        }

        return $webspaceKey;
    }
}

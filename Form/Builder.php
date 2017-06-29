<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form;

use Doctrine\ORM\NoResultException;
use Sulu\Bundle\FormBundle\Dynamic\Checksum;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Form\Type\DynamicFormType;
use Sulu\Bundle\FormBundle\Media\CollectionStrategyInterface;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPoolInterface;
use Sulu\Component\Content\Compat\Structure\PageBridge;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Builds a dynamic form.
 */
class Builder implements BuilderInterface
{
    /**
     * @var array
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
     * @var CollectionStrategyInterface
     */
    protected $collectionStrategy;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var string
     */
    protected $defaultStructureView;

    /**
     * @var Checksum
     */
    private $checksum;

    /**
     * Builder constructor.
     *
     * @param RequestStack $requestStack
     * @param FormFieldTypePool $formFieldTypePool
     * @param TitleProviderPoolInterface $titleProviderPool
     * @param FormRepository $formRepository
     * @param CollectionStrategyInterface $collectionStrategy
     * @param FormFactory $formFactory
     * @param Checksum $checksum
     * @param string $defaultStructureView
     */
    public function __construct(
        RequestStack $requestStack,
        FormFieldTypePool $formFieldTypePool,
        TitleProviderPoolInterface $titleProviderPool,
        FormRepository $formRepository,
        CollectionStrategyInterface $collectionStrategy,
        FormFactory $formFactory,
        Checksum $checksum,
        $defaultStructureView
    ) {
        $this->requestStack = $requestStack;
        $this->formFieldTypePool = $formFieldTypePool;
        $this->titleProviderPool = $titleProviderPool;
        $this->formRepository = $formRepository;
        $this->collectionStrategy = $collectionStrategy;
        $this->formFactory = $formFactory;
        $this->defaultStructureView = $defaultStructureView;
        $this->checksum = $checksum;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function buildByRequest(Request $request)
    {
        foreach ($request->request->all() as $key => $parameters) {
            if (strpos($key, 'dynamic_') === 0) {
                $formNameParts = explode('dynamic_', $key, 2);
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

                $locale = $request->getLocale();

                if (!isset($parameters['type'])
                    || !isset($parameters['formId'])
                    || !isset($parameters['formName'])
                    || !isset($parameters['typeId'])
                ) {
                    continue;
                }

                return $this->build($parameters['formId'], $parameters['type'], $parameters['typeId'], $locale, $parameters['formName']);
            }
        }

        return [null, null];
    }

    /**
     * Returns formType and the builded form.
     *
     * @param int $id
     * @param string $type
     * @param string $typeId
     * @param string $locale
     * @param string $name
     *
     * @return array
     */
    public function build($id, $type, $typeId, $locale = null, $name = 'form')
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
     *
     * @param int $id
     * @param string $type
     * @param string $typeId
     * @param string $locale
     * @param string $name
     *
     * @return array
     */
    protected function buildForm($id, $type, $typeId, $locale, $name)
    {
        $request = $this->requestStack->getCurrentRequest();

        // Load Form entity
        $formEntity = $this->loadFormEntity($id, $locale);

        if (!$formEntity) {
            return [null, null];
        }

        $webspaceKey = $this->getWebspaceKey();
        $defaults = $this->getDefaults($formEntity, $locale);

        // Create Form Type
        $formType = $this->createFormType(
            $formEntity,
            $locale,
            $name,
            $type,
            $typeId
        );

        // Create Form
        $form = $this->createForm(
            $formType,
            $type,
            $typeId,
            $locale,
            $formEntity,
            $webspaceKey,
            $defaults
        );

        // Handle request
        $form->handleRequest($request);

        return [$formType, $form];
    }

    /**
     * Get key.
     *
     * @param int $id
     * @param string $type
     * @param string $typeId
     * @param string $locale
     * @param string $name
     *
     * @return string
     */
    protected function getKey($id, $type, $typeId, $locale, $name)
    {
        return implode('__', func_get_args());
    }

    /**
     * @deprecated Need to be refractored for symfony 3.0 and will be removed in one of the next released.
     *
     * Create form.
     *
     * @param string $formType
     * @param string $type
     * @param string $typeId
     * @param string $locale
     * @param Form $formEntity
     * @param string $webspaceKey
     * @param array $defaults
     *
     * @return FormInterface
     */
    protected function createForm($formType, $type, $typeId, $locale, $formEntity, $webspaceKey, $defaults)
    {
        $typeName = $this->titleProviderPool->get($type)->getTitle($typeId);

        return $this->formFactory->create(
            $formType,
            new Dynamic($type, $typeId, $locale, $formEntity, $defaults, $webspaceKey, $typeName)
        );
    }

    /**
     * @deprecated Will be removed in one of the next released.
     *
     * Load Form entity.
     *
     * @param $id
     * @param $locale
     *
     * @return Form
     */
    protected function loadFormEntity($id, $locale)
    {
        try {
            // Load Form entity
            $formEntity = $this->formRepository->findById($id, $locale);
        } catch (NoResultException $e) {
            return;
        }

        $translation = $formEntity->getTranslation($locale);

        if (!$translation) {
            // No translation for this locale exists
            return;
        }

        return $formEntity;
    }

    /**
     * @deprecated Need to be refractored for symfony 3.0 and will be removed in one of the next released.
     *
     * Create form type.
     *
     * @param Form $formEntity
     * @param string $locale
     * @param string $name
     * @param string $type
     * @param string $typeId
     *
     * @return DynamicFormType
     */
    protected function createFormType(
        Form $formEntity,
        $locale,
        $name,
        $type,
        $typeId
    ) {
        /** @var PageBridge $structure */
        $structure = $this->requestStack->getCurrentRequest()->attributes->get('structure');

        $structureView = $this->defaultStructureView;

        if ($structure) {
            $structureView = $structure->getView();
        }

        return new DynamicFormType(
            $formEntity,
            $locale,
            $name,
            $structureView,
            $this->collectionStrategy->getCollectionId(
                $formEntity->getId(),
                $formEntity->getTranslation($locale)->getTitle(),
                $type,
                $typeId,
                $locale
            ),
            $this->formFieldTypePool,
            $this->checksum,
            $type,
            $typeId
        );
    }

    /**
     * Get defaults.
     *
     * @param Form $formEntity
     * @param string $locale
     *
     * @return array
     */
    protected function getDefaults(Form $formEntity, $locale)
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

    /**
     * Get webspace key.
     *
     * @return string
     */
    protected function getWebspaceKey()
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

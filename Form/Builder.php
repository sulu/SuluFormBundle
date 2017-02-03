<?php

namespace Sulu\Bundle\FormBundle\Form;

use Doctrine\ORM\NoResultException;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Form\Type\DynamicFormType;
use Sulu\Bundle\FormBundle\Media\CollectionStrategyInterface;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Component\Content\Compat\Structure\PageBridge;
use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

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
     * Builder constructor.
     *
     * @param RequestStack $requestStack
     * @param FormFieldTypePool $formFieldTypePool
     * @param FormRepository $formRepository
     * @param CollectionStrategyInterface $collectionStrategy
     * @param FormFactory $formFactory
     * @param string $defaultStructureView
     */
    public function __construct(
        RequestStack $requestStack,
        FormFieldTypePool $formFieldTypePool,
        FormRepository $formRepository,
        CollectionStrategyInterface $collectionStrategy,
        FormFactory $formFactory,
        $defaultStructureView
    ) {
        $this->requestStack = $requestStack;
        $this->formFieldTypePool = $formFieldTypePool;
        $this->formRepository = $formRepository;
        $this->collectionStrategy = $collectionStrategy;
        $this->formFactory = $formFactory;
        $this->defaultStructureView = $defaultStructureView;
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

                if (!isset($formNameParts[1])) {
                    continue;
                }

                $name = $formNameParts[1];
                $locale = $request->getLocale();

                $structure = $request->attributes->get('structure');

                if (
                    !$structure instanceof StructureInterface
                    || !$structure->hasProperty('title')
                    || !$structure->hasProperty($name)
                ) {
                    continue;
                }

                $typeId = $structure->getUuid();
                $typeName = $structure->getProperty('title')->getValue();
                $id = (int) $structure->getProperty($name)->getValue();

                if (!$typeId || !$id || !$typeName) {
                    continue;
                }

                return $this->build($id, 'page', $typeId, $typeName, $locale, $name);
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
     * @param string $typeName
     * @param string $locale
     * @param string $name
     *
     * @return array
     */
    public function build($id, $type, $typeId, $typeName, $locale = null, $name = 'form')
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$locale) {
            $locale = $request->getLocale();
        }

        // Check if form was builded before and return the cached form.
        $key = $this->getKey($id, $type, $typeId, $typeName, $locale, $name);

        if (!isset($this->cache[$key])) {
            $this->cache[$key] = $this->buildForm($id, $type, $typeId, $typeName, $locale, $name);
        }

        return $this->cache[$key];
    }

    /**
     * Returns formType and the built form.
     *
     * @param int $id
     * @param string $type
     * @param string $typeId
     * @param string $typeName
     * @param string $locale
     * @param string $name
     *
     * @return array
     */
    protected function buildForm($id, $type, $typeId, $typeName, $locale, $name)
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
            $typeId,
            $typeName
        );

        // Create Form
        $form = $this->createForm(
            $formType,
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
     * @param string $typeName
     * @param string $locale
     * @param string $name
     *
     * @return string
     */
    protected function getKey($id, $type, $typeId, $typeName, $locale, $name)
    {
        return implode('__', func_get_args());
    }

    /**
     * Create form.
     *
     * @param $formType
     * @param $typeId
     * @param $locale
     * @param $formEntity
     * @param $webspaceKey
     * @param $defaults
     *
     * @return FormInterface
     */
    protected function createForm($formType, $typeId, $locale, $formEntity, $webspaceKey, $defaults)
    {
        return $this->formFactory->create(
            $formType,
            new Dynamic($typeId, $locale, $formEntity, $webspaceKey, $defaults)
        );
    }

    /**
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
     * Create form type.
     *
     * @param Form $formEntity
     * @param string $locale
     * @param string $name
     * @param string $type
     * @param string $typeId
     * @param string $typeName
     *
     * @return DynamicFormType
     */
    protected function createFormType(
        Form $formEntity,
        $locale,
        $name,
        $type,
        $typeId,
        $typeName
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
                $typeName,
                $locale
            ),
            $this->formFieldTypePool
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
                $value = $fieldTranslation->getDefaultValue();

                // handle special types
                switch ($field->getType()) {
                    case Dynamic::TYPE_DATE:
                        $value = new \DateTime($value);
                        break;
                    case Dynamic::TYPE_DROPDOWN_MULTIPLE:
                    case Dynamic::TYPE_CHECKBOX_MULTIPLE:
                        $value = preg_split('/\r\n|\r|\n/', $value, -1, PREG_SPLIT_NO_EMPTY);
                        break;
                }

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

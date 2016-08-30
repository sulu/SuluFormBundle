<?php

namespace L91\Sulu\Bundle\FormBundle\Content\Types;

use Doctrine\ORM\NoResultException;
use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use L91\Sulu\Bundle\FormBundle\Event\DynFormSavedEvent;
use L91\Sulu\Bundle\FormBundle\Form\HandlerInterface;
use L91\Sulu\Bundle\FormBundle\Form\Type\DynamicFormType;
use L91\Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\SimpleContentType;
use Sulu\Component\Media\SystemCollections\SystemCollectionManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * ContentType for selecting a form.
 */
class FormSelect extends SimpleContentType
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var FormRepository
     */
    private $formRepository;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var HandlerInterface
     */
    private $formHandler;

    /**
     * @var SystemCollectionManagerInterface
     */
    private $systemCollectionManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * FormSelect constructor.
     *
     * @param string $template
     * @param FormRepository $formRepository
     * @param RequestStack $requestStack
     * @param FormFactoryInterface $formFactory
     * @param HandlerInterface $formHandler
     * @param SystemCollectionManagerInterface $systemCollectionManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        $template,
        FormRepository $formRepository,
        RequestStack $requestStack,
        FormFactoryInterface $formFactory,
        HandlerInterface $formHandler,
        SystemCollectionManagerInterface $systemCollectionManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct('FormSelect', '');
        $this->template = $template;
        $this->formRepository = $formRepository;
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
        $this->systemCollectionManager = $systemCollectionManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentData(PropertyInterface $property)
    {
        $id = (int) $property->getValue();

        if (!$id) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();

        $form = null;

        try {
            // Create Dynamic Data
            $uuid = $property->getStructure()->getUuid();
            $webspaceKey = $property->getStructure()->getWebspaceKey();
            $locale = $property->getStructure()->getLanguageCode();
            $formEntity = $this->formRepository->findById($id, $locale);

            // set Defaults
            $defaults = [];
            foreach ($formEntity->getFields() as $field) {
                $translation = $field->getTranslation($locale);

                if ($translation && $translation->getDefaultValue()) {
                    $value = $translation->getDefaultValue();

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

            // Create Form Type
            $formType = new DynamicFormType(
                $formEntity,
                $locale,
                $property->getName(),
                $property->getStructure()->getView(),
                $this->systemCollectionManager->getSystemCollection('l91_sulu_form.attachments')
            );

            $form = $this->formFactory->create(
                $formType,
                new Dynamic($uuid, $locale, $formEntity, $webspaceKey, $defaults)
            );

            // handle request
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $serializedObject = $formEntity->serializeForLocale($locale, $form->getData());

                // save
                $this->formHandler->handle(
                    $form,
                    [
                        '_form_type' => $formType,
                        'formEntity' => $serializedObject,
                    ]
                );

                $event = new DynFormSavedEvent($serializedObject);
                $this->eventDispatcher->dispatch(DynFormSavedEvent::NAME, $event);

                // Do redirect after success
                throw new HttpException(302, null, null, ['Location' => '?send=true']);
            }

            return $form->createView();
        } catch (NoResultException $e) {
            // do nothing
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getViewData(PropertyInterface $property)
    {
        $id = (int) $property->getValue();

        if (!$id) {
            return [];
        }

        $locale = $property->getStructure()->getLanguageCode();

        $formEntity = $this->formRepository->findById($id, $locale);

        return [
            'entity' => $formEntity->serializeForLocale($locale),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }
}

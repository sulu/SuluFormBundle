<?php

namespace L91\Sulu\Bundle\FormBundle\Content\Types;

use Doctrine\ORM\NoResultException;
use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use L91\Sulu\Bundle\FormBundle\Form\HandlerInterface;
use L91\Sulu\Bundle\FormBundle\Form\Type\DynamicFormType;
use L91\Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Component\Content\Compat\PropertyInterface;
use Sulu\Component\Content\SimpleContentType;
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

    public function __construct(
        $template,
        FormRepository $formRepository,
        RequestStack $requestStack,
        FormFactoryInterface $formFactory,
        HandlerInterface $formHandler
    ) {
        parent::__construct('FormSelect', '');
        $this->template = $template;
        $this->formRepository = $formRepository;
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function getContentData(PropertyInterface $property)
    {
        $id = (int)$property->getValue();

        if (!$id) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();

        $form = null;

        try {
            $uuid = null; // TODO get uuid
            $webspaceKey = null; // TODO get webspaceKey
            $locale = $request->getLocale();
            $formEntity = $this->formRepository->findById($id, $locale);

            $defaults = [];
            foreach ($formEntity->getFields() as $field) {
                $translation = $field->getTranslation($locale);

                if ($translation && $translation->getDefaultValue()) {
                    $defaults[$field->getKey()] = $translation->getDefaultValue();
                }
            }

            $form = $this->formFactory->create(
                new DynamicFormType($formEntity, $property->getName(), $locale),
                new Dynamic($uuid, $locale, $webspaceKey, $defaults)
            );

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->formHandler->handle($form);

                // Do redirect after success
                throw new HttpException(302, null, null, ['Location' => '?send=true']);
            }

            return $form->createView();
        } catch (NoResultException $e) {
            // do nothing
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }
}

<?php

namespace L91\Sulu\Bundle\FormBundle\Form\Type;

use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use L91\Sulu\Bundle\FormBundle\Entity\Form;
use L91\Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DynamicFormType extends AbstractType
{
    /**
     * @var Form
     */
    private $formEntity;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $structureView;

    /**
     * @var string
     */
    private $name;

    /**
     * DynamicFormType constructor.
     *
     * @param Form $formEntity
     * @param string $locale
     * @param string $name
     * @param string $structureView
     */
    public function __construct($formEntity, $locale, $name, $structureView)
    {
        $this->formEntity = $formEntity;
        $this->locale = $locale;
        $this->name = $name;
        $this->structureView = $structureView;
    }

    /**
     * {@inheritdoc}
     */
    protected $dataClass = Dynamic::class;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->formEntity->getFields() as $field) {
            $translation = $field->getTranslation($this->locale);
            $name = $field->getKey();
            $type = TextType::class;
            $options = ['constraints' => [], 'attr' => [], 'required' => false];

            // skip $type headline, use for the next field
            if ('headline' === $field->getType()) {
                $headline = $translation->getTitle();
                continue;
            }

            // headline
            if (isset($headline) && '' !== $headline) {
                $options['attr']['headline'] = $headline;
                $headline = '';
            }

            // required
            $options['required'] = $field->getRequired();

            if ($field->getRequired()) {
                $options['required'] = true;
                $options['constraints'][] = new NotBlank();
            }

            // title / placeholder
            if ($translation) {
                $options['attr']['placeholder'] = $translation->getPlaceholder();
                $options['label'] = $translation->getTitle();
            }

            // Form Type
            switch ($field->getType()) {
                case 'salutation':
                    $type = ChoiceType::class;

                    $options['choices'] = [
                        'mr' => 'l91_sulu_form.salutation_mr',
                        'ms' => 'l91_sulu_form.salutation_ms',
                    ];
                    break;
                case 'headline':
                    continue;
                    break;
                case 'textarea':
                    $type = TextareaType::class;
                    break;
                case 'country':
                    $type = CountryType::class;
                    break;
                case 'attachment':
                    $type = FileType::class;
                    break;
                case 'checkbox':
                    $type = CheckboxType::class;
                    break;
                case 'checkboxes':
                    $type = $this->createChoiceType($translation, $options, true, true);
                    break;
                case 'select':
                    $type = $this->createChoiceType($translation, $options);
                    break;
                case 'multiple_select':
                    $type = $this->createChoiceType($translation, $options, false, true);
                    break;
                case 'radio_buttons':
                    $type = $this->createChoiceType($translation, $options, true);
                    break;
            }

            $builder->add($name, $type, $options);
        }

        $builder->add('submit', SubmitType::class);
    }

    /**
     * @description Choice Type handles four form types (select, multiple select, radio, checkboxes)
     * (http://symfony.com/doc/current/reference/forms/types/choice.html)
     *
     * @param FormFieldTranslation $translation
     * @param array $options
     * @param bool $expanded
     * @param bool $multiple
     */
    public function createChoiceType($translation, &$options, $expanded = false, $multiple = false)
    {
        if ($translation) {
            // placeholder
            $options['placeholder'] = $translation->getPlaceholder();

            // choices
            $choices = explode("\n", $translation->getOption('choices'));
            $options['choices'] = array_combine($choices, $choices);

            // type
            $options['expanded'] = $expanded;
            $options['multiple'] = $multiple;
        }

        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dynamic_' . $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerSubject($formData = [])
    {
        $translation = $this->formEntity->getTranslation($this->locale, true);

        return $translation->getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifySubject($formData = [])
    {
        $translation = $this->formEntity->getTranslation($this->locale, true);

        return $translation->getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerFromMailAddress($formData = [])
    {
        $translation = $this->formEntity->getTranslation($this->locale, true);

        return [$translation->getFromEmail() => $translation->getFromName()];
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyFromMailAddress($formData = [])
    {
        $translation = $this->formEntity->getTranslation($this->locale, true);

        return [$translation->getFromEmail() => $translation->getFromName()];
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyToMailAddress($formData = [])
    {
        $translation = $this->formEntity->getTranslation($this->locale, true);

        return [$translation->getToEmail() => $translation->getToName()];
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerMail($formData = [])
    {
        return $this->structureView . '-mail/' . $this->name . '-success.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyMail($formData = [])
    {
        return $this->structureView . '-mail/' . $this->name . '-notify.html.twig';
    }

    public function getCollectionId()
    {
        // TODO
    }
}

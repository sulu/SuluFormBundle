<?php

namespace L91\Sulu\Bundle\FormBundle\Form\Type;

use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use L91\Sulu\Bundle\FormBundle\Entity\Form;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            if (in_array($field->getType(), ['headline'])) {
                continue;
            }

            $translation = $field->getTranslation($this->locale);
            $name = $field->getKey();
            $type = TextType::class;
            $options = ['constraints' => [], 'attr' => [], 'required' => false];

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
                case 'headline':
                    continue;
                    break;
                case 'textarea':
                    $type = TextareaType::class;
                    break;
                case 'country':
                    $type = CountryType::class;
                    break;
                case 'checkbox':
                    $type = CheckboxType::class;
                    break;
                case 'attachment':
                    $type = FileType::class;
                    break;
                // Choices
                case 'multipleChoice':
                    $options['multiple'] = true;
                case 'choice':
                    $type = ChoiceType::class;

                    if ($translation) {
                        // placeholder
                        $options['placeholder'] = $translation->getPlaceholder();

                        // expanded
                        if ($translation->getOption('expanded')) {
                            $options['expanded'] = true;
                        }

                        // choices
                        $choices = explode("\n", $translation->getOption('choices'));
                        $options['choices'] = array_combine($choices, $choices);
                    }

                    break;
            }

            $builder->add($name, $type, $options);
        }

        $builder->add('submit', 'submit');
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
}
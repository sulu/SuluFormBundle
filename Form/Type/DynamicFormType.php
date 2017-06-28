<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form\Type;

use Sulu\Bundle\FormBundle\Dynamic\Checksum;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPoolInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
     * @var int
     */
    private $systemCollectionId;

    /**
     * @var FormFieldTypePool
     */
    private $typePool;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $typeId;

    /**
     * @var Checksum
     */
    private $checksum;

    /**
     * DynamicFormType constructor.
     *
     * @param Form $formEntity
     * @param string $locale
     * @param string $name
     * @param string $structureView
     * @param int $systemCollectionId
     * @param FormFieldTypePool $typePool
     * @param string $type
     * @param Checksum $checksum
     * @param string $typeId
     *
     * @internal param string $secret
     */
    public function __construct(
        Form $formEntity,
        $locale,
        $name,
        $structureView,
        $systemCollectionId,
        FormFieldTypePool $typePool,
        Checksum $checksum,
        $type,
        $typeId
    ) {
        $this->formEntity = $formEntity;
        $this->locale = $locale;
        $this->name = $name;
        $this->structureView = $structureView;
        $this->systemCollectionId = $systemCollectionId;
        $this->typePool = $typePool;
        $this->type = $type;
        $this->typeId = $typeId;
        $this->checksum = $checksum;
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
        if (!$this->formEntity->getTranslation($this->locale)) {
            throw new \Exception('The form with the ID "' . $this->formEntity->getId() . '" does not exist for the locale "' . $this->locale . '"!');
        }

        $currentWidthValue = 0;

        foreach ($this->formEntity->getFields() as $field) {
            $translation = $field->getTranslation($this->locale);
            $options = ['constraints' => [], 'attr' => [], 'required' => false];

            // title
            $title = '';
            $placeholder = '';
            $width = 'full';

            // title / placeholder
            if ($translation) {
                $title = $translation->getTitle();
                $placeholder = $translation->getPlaceholder();
            }

            // width
            if ($field->getWidth()) {
                $width = $field->getWidth();
            }

            $lastWidth = $this->getLastWidth($currentWidthValue, $width);

            $options['label'] = $title ?: false;
            $options['required'] = $field->getRequired();
            $options['attr']['width'] = $width;
            $options['attr']['lastWidth'] = $lastWidth;
            $options['attr']['placeholder'] = $placeholder;

            // required
            if ($field->getRequired()) {
                $options['constraints'][] = new NotBlank();
            }

            $this->typePool->get($field->getType())->build($builder, $field, $this->locale, $options);
        }

        // Add hidden type field. (structure, event, blog,…)
        $builder->add('type', HiddenType::class, [
            'data' => $this->type,
        ]);

        // Add hidden typeId field. (UUID, Database id,…)
        $builder->add('typeId', HiddenType::class, [
            'data' => $this->typeId,
        ]);

        // Add hidden formId. (id, uuid,…)
        $builder->add('formId', HiddenType::class, [
            'data' => $this->formEntity->getId(),
        ]);

        // Add hidden formName field. (Name of "form_select"-content-type.)
        $builder->add('formName', HiddenType::class, [
            'data' => $this->name,
        ]);

        // Add hidden formName field. (Name of "form_select"-content-type.)
        $checksum = $this->checksum->get($this->type, $this->typeId, $this->formEntity->getId(), $this->name);
        $builder->add('checksum', HiddenType::class, [
            'data' => $checksum,
        ]);

        // Add submit button.
        $builder->add('submit', SubmitType::class, ['label' => $this->getSubmitLabel()]);
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
     *
     * @deprecated
     */
    public function getCustomerSubject($formData = [])
    {
        return $this->getTranslation()->getSubject();
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getNotifySubject($formData = [])
    {
        return $this->getTranslation()->getSubject();
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getCustomerFromMailAddress($formData = [])
    {
        $fromMail = $this->getTranslation()->getFromEmail();
        $fromName = $this->getTranslation()->getFromName();

        if (!$fromMail || !$fromName) {
            return;
        }

        return [$fromMail => $fromName];
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getNotifyFromMailAddress($formData = [])
    {
        $fromMail = $this->getTranslation()->getFromEmail();
        $fromName = $this->getTranslation()->getFromName();

        if (!$fromMail || !$fromName) {
            return;
        }

        return [$fromMail => $fromName];
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getNotifyToMailAddress($formData = [])
    {
        $toMail = $this->getTranslation()->getToEmail();
        $toName = $this->getTranslation()->getToName();

        if (!$toMail || !$toName) {
            return;
        }

        return [$toMail => $toName];
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getNotifyReplyToMailAddress($formData = [])
    {
        if ($this->getTranslation()->getReplyTo()) {
            $email = $this->getCustomerToMailAddress($formData);

            if (!$email) {
                return $email;
            }
        }

        return parent::getNotifyReplyToMailAddress($formData);
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getCustomerMail($formData = [])
    {
        return $this->structureView . '-mail/' . $this->name . '-success.html.twig';
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getCustomerToMailAddress($formData = [])
    {
        $email = null;

        if ($formData instanceof Dynamic) {
            $emails = $formData->getFieldsByType('email');
            $email = reset($emails);
        }

        if (!$email) {
            $email = parent::getCustomerToMailAddress($formData);
        }

        return $email;
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getNotifyMail($formData = [])
    {
        return $this->structureView . '-mail/' . $this->name . '-notify.html.twig';
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getNotifySendAttachments($formData = [])
    {
        return $this->getTranslation()->getSendAttachments();
    }

    /**
     * @param $formData
     *
     * @return bool
     *
     * @deprecated
     */
    public function getNotifyDeactivateMails($formData = [])
    {
        // Deactivated because of using MailSubscriber service.
        return true;
    }

    /**
     * @param $formData
     *
     * @return bool
     *
     * @deprecated
     */
    public function getCustomerDeactivateMails($formData = [])
    {
        // Deactivated because of using MailSubscriber service.
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getMailText($formData = [])
    {
        return $this->getTranslation()->getMailText();
    }

    /**
     * {@inheritdoc}
     */
    public function getSubmitLabel($formData = [])
    {
        return $this->getTranslation()->getSubmitLabel();
    }

    /**
     * {@inheritdoc}
     */
    public function getSuccessText($formData = [])
    {
        return $this->getTranslation()->getSuccessText();
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionId()
    {
        return $this->systemCollectionId;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileFields()
    {
        $fileFields = [];

        foreach ($this->formEntity->getFieldsByType(Dynamic::TYPE_ATTACHMENT) as $field) {
            $fileFields[] = $field->getKey();
        }

        return $fileFields;
    }

    /**
     * @return FormTranslation|null
     */
    public function getTranslation()
    {
        return $this->formEntity->getTranslation($this->locale, false, true);
    }

    /**
     * @param int $currentWidthValue
     * @param string $width
     *
     * @return bool
     */
    private function getLastWidth(&$currentWidthValue, $width)
    {
        switch ($width) {
            case 'one-sixth':
                $itemWidth = 2;
                break;
            case 'five-sixths':
                $itemWidth = 10;
                break;
            case 'one-quarter':
                $itemWidth = 3;
                break;
            case 'three-quarters':
                $itemWidth = 9;
                break;
            case 'one-third':
                $itemWidth = 4;
                break;
            case 'two-thirds':
                $itemWidth = 8;
                break;
            case 'half':
                $itemWidth = 6;
                break;
            case 'full':
                $itemWidth = 12;
                break;
            default:
                $itemWidth = 12;
        }

        $currentWidthValue += $itemWidth;

        if ($currentWidthValue % 12 == 0) {
            return true;
        }

        return false;
    }
}

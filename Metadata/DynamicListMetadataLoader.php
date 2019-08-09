<?php


namespace Sulu\Bundle\FormBundle\Metadata;


use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\FieldMetadata;
use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\ListMetadata;
use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\ListMetadataLoaderInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Manager\FormManager;
use Sulu\Bundle\FormBundle\Repository\DynamicRepository;
use Symfony\Component\Translation\TranslatorInterface;

class DynamicListMetadataLoader implements ListMetadataLoaderInterface
{
    /**
     * @var FormFieldTypePool
     */
    private $formFieldTypePool;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var FormManager
     */
    private $formManager;

    public function __construct(
        FormFieldTypePool $formFieldTypePool,
        TranslatorInterface $translator,
        FormManager $formManager
    )
    {
        $this->formFieldTypePool = $formFieldTypePool;
        $this->translator = $translator;
        $this->formManager = $formManager;
    }


    public function getMetadata(string $key, string $locale, array $metadataOptions): ?ListMetadata
    {
        $list = new ListMetadata();
        $form = $this->getForm($metadataOptions, $locale);
        if (!$form) {
            return null;
        }
        $fields = $form->getFields();

        foreach ($fields as $field) {
            $key = $field->getKey();
            $fieldType = $this->formFieldTypePool->get($key);
            $title = $fieldType->getConfiguration()->getTitle();
            $fieldMetadata = $this->createFieldMetadata($key, $title, $locale);
            $list->addField($fieldMetadata);
        }
        $list->setCacheable(false);
        return $list;
    }

    private function getForm(array $metadataOptions, string $locale): ?Form
    {
        if (!array_key_exists('id', $metadataOptions)) {
            return null;
        }
        $entity = $this->formManager->findById($metadataOptions['id'], $locale);

        if (!$entity) {
            return null;
        }
        return $entity;
    }

    private function createFieldMetadata(string $name, string $title, string $locale) : FieldMetadata
    {
        $field = new FieldMetadata($name);
        $field->setLabel($this->translator->trans($title, [], 'admin', $locale));
        $field->setType('string');
        $field->setVisibility('yes');
        $field->setSortable(true);

        return $field;
    }


}
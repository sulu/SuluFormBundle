<?php


namespace Sulu\Bundle\FormBundle\Metadata;

use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\FieldMetadata;
use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\ListMetadata;
use Sulu\Bundle\AdminBundle\Metadata\ListMetadata\ListMetadataLoaderInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Manager\FormManager;
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
    ) {
        $this->formFieldTypePool = $formFieldTypePool;
        $this->translator = $translator;
        $this->formManager = $formManager;
    }


    public function getMetadata(string $key, string $locale, array $metadataOptions): ?ListMetadata
    {
        if (strcmp('form_data', $key) !== 0) {
            return null;
        }

        $list = new ListMetadata();

        $form = $this->getForm($metadataOptions, $locale);
        if (!$form) {
            return null;
        }

        $list = $this->addId($list, $locale);

        $fields = $form->getFields();
        foreach ($fields as $field) {
            $key = $field->getKey();
            $fieldType = $this->formFieldTypePool->get($key);
            $title = $fieldType->getConfiguration()->getTitle();
            $fieldMetadata = $this->createDynamicFieldMetadata($key, $title, $locale);
            $list->addField($fieldMetadata);
        }

        $list = $this->addCreatedAndChanged($list, $locale);
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

    private function createDynamicFieldMetadata(string $name, string $title, string $locale) : FieldMetadata
    {
        $field = new FieldMetadata($name);
        $field->setLabel($this->translator->trans($title, [], 'admin', $locale));
        $field->setType('string');
        $field->setVisibility('yes');
        $field->setSortable(true);

        return $field;
    }

    private function addId(ListMetadata $list, string $locale) : ListMetadata
    {
        $id = new FieldMetadata('id');
        $id->setLabel($this->translator->trans('sulu_form.id', [], 'admin', $locale));
        $id->setType('string');
        $id->setVisibility('yes');
        $id->setSortable(true);
        $list->addField($id);

        return $list;
    }

    private function addCreatedAndChanged(ListMetadata $list, string $locale): ListMetadata
    {
        $created = new FieldMetadata('created');
        $created->setLabel($this->translator->trans('sulu_admin.created', [], 'admin', $locale));
        $created->setType('datetime');
        $created->setVisibility('yes');
        $created->setSortable(true);
        $list->addField($created);

        $changed = new FieldMetadata('changed');
        $changed->setLabel($this->translator->trans('sulu_admin.changed', [], 'admin', $locale));
        $changed->setType('datetime');
        $changed->setVisibility('no');
        $changed->setSortable(true);
        $list->addField($changed);

        return $list;
    }
}

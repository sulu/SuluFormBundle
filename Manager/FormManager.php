<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\ActivityBundle\Application\Collector\DomainEventCollectorInterface;
use Sulu\Bundle\FormBundle\Domain\Event\FormCopiedEvent;
use Sulu\Bundle\FormBundle\Domain\Event\FormCreatedEvent;
use Sulu\Bundle\FormBundle\Domain\Event\FormModifiedEvent;
use Sulu\Bundle\FormBundle\Domain\Event\FormRemovedEvent;
use Sulu\Bundle\FormBundle\Domain\Event\FormTranslationAddedEvent;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslationReceiver;
use Sulu\Bundle\FormBundle\Exception\FormNotFoundException;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\TrashBundle\Application\TrashManager\TrashManagerInterface;

class FormManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var FormRepository
     */
    protected $formRepository;

    /**
     * @var DomainEventCollectorInterface
     */
    private $domainEventCollector;

    /**
     * @var TrashManagerInterface|null
     */
    private $trashManager;

    /**
     * EventManager constructor.
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FormRepository $formRepository,
        DomainEventCollectorInterface $domainEventCollector,
        ?TrashManagerInterface $trashManager
    ) {
        $this->entityManager = $entityManager;
        $this->formRepository = $formRepository;
        $this->domainEventCollector = $domainEventCollector;
        $this->trashManager = $trashManager;
    }

    public function findById(int $id, ?string $locale = null): ?Form
    {
        return $this->formRepository->loadById($id, $locale);
    }

    /**
     * @param mixed[] $filters
     *
     * @return null|Form[]
     */
    public function findAll(?string $locale = null, array $filters = []): ?array
    {
        return $this->formRepository->loadAll($locale, $filters);
    }

    /**
     * @param mixed[] $filters
     */
    public function count(?string $locale = null, array $filters = []): int
    {
        return $this->formRepository->countByFilters($locale, $filters);
    }

    public function copy(int $id, string $locale): Form
    {
        $form = $this->findById($id);

        if (!$form) {
            throw new FormNotFoundException($id, null);
        }

        $newForm = new Form();
        $newForm->setDefaultLocale($form->getDefaultLocale());

        foreach ($form->getTranslations() as $translation) {
            /** @var FormTranslation $newFormTranslation */
            $newFormTranslation = $newForm->getTranslation($translation->getLocale(), true);
            $newFormTranslation->setTitle($translation->getTitle() . ' (2)');
            $newFormTranslation->setSubject($translation->getSubject());
            $newFormTranslation->setFromEmail($translation->getFromEmail());
            $newFormTranslation->setFromName($translation->getFromName());
            $newFormTranslation->setToEmail($translation->getToEmail());
            $newFormTranslation->setToName($translation->getToName());
            $newFormTranslation->setMailText($translation->getMailText());
            $newFormTranslation->setSubmitLabel($translation->getSubmitLabel());
            $newFormTranslation->setSuccessText($translation->getSuccessText());
            $newFormTranslation->setSendAttachments($translation->getSendAttachments());
            $newFormTranslation->setDeactivateAttachmentSave($translation->getDeactivateAttachmentSave());
            $newFormTranslation->setDeactivateNotifyMails($translation->getDeactivateNotifyMails());
            $newFormTranslation->setDeactivateCustomerMails($translation->getDeactivateCustomerMails());
            $newFormTranslation->setReplyTo($translation->getReplyTo());
            $newFormTranslation->setChanged(new \DateTimeImmutable());
            $newFormTranslation->setForm($newForm);
            $newForm->addTranslation($newFormTranslation);

            foreach ($translation->getReceivers() as $receiver) {
                $newReceiver = new FormTranslationReceiver();
                $newReceiver->setType($receiver->getType());
                $newReceiver->setEmail($receiver->getEmail());
                $newReceiver->setName($receiver->getName());
                $newReceiver->setFormTranslation($newFormTranslation);
                $newFormTranslation->addReceiver($newReceiver);
            }
        }

        foreach ($form->getFields() as $field) {
            $newField = new FormField();
            $newField->setDefaultLocale($field->getDefaultLocale());
            $newField->setKey($field->getKey());
            $newField->setType($field->getType());
            $newField->setOrder($field->getOrder());
            $newField->setWidth($field->getWidth());
            $newField->setRequired($field->getRequired());

            foreach ($field->getTranslations() as $fieldTranslation) {
                /** @var FormFieldTranslation $newFieldTranslation */
                $newFieldTranslation = $newField->getTranslation($fieldTranslation->getLocale(), true);
                $newFieldTranslation->setTitle($fieldTranslation->getTitle());
                $newFieldTranslation->setPlaceholder($fieldTranslation->getPlaceholder());
                $newFieldTranslation->setDefaultValue($fieldTranslation->getDefaultValue());
                $newFieldTranslation->setShortTitle($fieldTranslation->getShortTitle());
                $newFieldTranslation->setOptions($fieldTranslation->getOptions());
            }

            $newField->setForm($newForm);
            $newForm->addField($newField);
        }

        /** @var FormTranslation $newFormTranslation */
        $newFormTranslation = $newForm->getTranslation($locale, false, true);

        $this->domainEventCollector->collect(
            new FormCopiedEvent(
                $newForm,
                $id,
                $newFormTranslation->getTitle(),
                $locale
            )
        );

        $this->entityManager->persist($newForm);
        $this->entityManager->flush();

        return $newForm;
    }

    /**
     * @param mixed[] $data
     */
    public function save(array $data, ?string $locale = null, ?int $id = null, ?bool $omitDomainEvent = false): ?Form
    {
        if (null === $locale) {
            return null;
        }

        $form = new Form();

        // Find exist or create new entity.
        if ($id) {
            $form = $this->findById($id, $locale);

            if (!$form) {
                return null;
            }
        }

        $isNewTranslation = !$form->getTranslation($locale, false, false);
        $translation = $form->getTranslation($locale, true);
        $translation->setTitle(self::getStringValue($data, 'title') ?? '');
        $translation->setSubject(self::getStringValue($data, 'subject'));
        $translation->setFromEmail(self::getStringValue($data, 'fromEmail'));
        $translation->setFromName(self::getStringValue($data, 'fromName'));
        $translation->setToEmail(self::getStringValue($data, 'toEmail'));
        $translation->setToName(self::getStringValue($data, 'toName'));
        $translation->setMailText(self::getStringValue($data, 'mailText'));
        $translation->setSubmitLabel(self::getStringValue($data, 'submitLabel'));
        $translation->setSuccessText(self::getStringValue($data, 'successText'));
        $translation->setSendAttachments(self::getBoolValue($data, 'sendAttachments'));
        $translation->setDeactivateAttachmentSave($translation->getSendAttachments() && self::getBoolValue($data, 'deactivateAttachmentSave'));
        $translation->setDeactivateNotifyMails(self::getBoolValue($data, 'deactivateNotifyMails'));
        $translation->setDeactivateCustomerMails(self::getBoolValue($data, 'deactivateCustomerMails'));
        $translation->setReplyTo(self::getBoolValue($data, 'replyTo'));
        $translation->setChanged(new \DateTimeImmutable());

        // Add Translation to Form.
        if (!$translation->getId()) {
            $translation->setForm($form);
            $form->addTranslation($translation);
        }

        // Set Default Locale.
        if (!$form->getId()) {
            $form->setDefaultLocale($locale);
        }

        // Update field of form and the receivers.
        $this->updateFields($data, $form, $locale);
        $this->updateReceivers($data, $translation);

        if (!$omitDomainEvent) {
            if (!$id) {
                $this->domainEventCollector->collect(new FormCreatedEvent($form, $locale, $data));
            } elseif ($isNewTranslation) {
                $this->domainEventCollector->collect(new FormTranslationAddedEvent($form, $locale, $data));
            } else {
                $this->domainEventCollector->collect(new FormModifiedEvent($form, $locale, $data));
            }
        }

        $this->entityManager->persist($form);
        $this->entityManager->flush();

        if (!$id) {
            // To avoid lazy load of sub entities in the serializer reload whole object with sub entities from db
            // remove this when you don`t join anything in `findById`.
            $persistedId = $form->getId();
            if (null === $persistedId) {
                throw new \RuntimeException('Form was persisted but has no id.');
            }
            $form = $this->findById($persistedId, $locale);
        }

        return $form;
    }

    public function delete(int $id, ?string $locale = null): ?Form
    {
        $object = $this->findById($id, $locale);

        if (!$object) {
            return null;
        }

        if ($this->trashManager) {
            $this->trashManager->store(Form::RESOURCE_KEY, $object);
        }

        /** @var FormTranslation $translation */
        $translation = $object->getTranslation($locale, false, true);
        $this->domainEventCollector->collect(
            new FormRemovedEvent($id, $translation->getTitle(), $translation->getLocale())
        );

        $this->entityManager->remove($object);
        $this->entityManager->flush();

        return $object;
    }

    /**
     * @param mixed[] $data
     */
    public function updateReceivers(array $data, FormTranslation $translation): void
    {
        $receiversRepository = $this->entityManager->getRepository(FormTranslationReceiver::class);
        $receiverDatas = self::getValue($data, 'receivers', []);
        \assert(\is_array($receiverDatas), 'Receivers must be an array.');

        // Remove old receivers.
        $oldReceivers = $receiversRepository->findBy(['formTranslation' => $translation]);
        /** @var FormTranslationReceiver $oldReceiver */
        foreach ($oldReceivers as $oldReceiver) {
            $translation->removeReceiver($oldReceiver);
            $this->entityManager->remove($oldReceiver);
        }

        $receivers = [];
        foreach ($receiverDatas as $receiverData) {
            if (!\is_array($receiverData)) {
                continue;
            }
            $receiver = new FormTranslationReceiver();
            $receiver->setType(self::getStringValue($receiverData, 'type') ?? '');
            $receiver->setEmail(self::getStringValue($receiverData, 'email') ?? '');
            $receiver->setName(self::getStringValue($receiverData, 'name') ?? '');
            $receiver->setFormTranslation($translation);

            $receivers[] = $receiver;
            $this->entityManager->persist($receiver);
            $translation->addReceiver($receiver);
        }
    }

    /**
     * Updates the contained fields in the form.
     *
     * @param mixed[] $data
     */
    protected function updateFields(array $data, Form $form, string $locale): void
    {
        $fields = self::getValue($data, 'fields', []);
        \assert(\is_array($fields), 'Fields must be an array.');

        $existingIds = [];
        $existingKeys = [];
        foreach ($fields as $key => $fieldData) { // make id and keys unique when block get copied
            if (!\is_array($fieldData)) {
                continue;
            }
            if (\in_array($fieldData['id'] ?? null, $existingIds)) {
                unset($fields[$key]['id']);
            }
            if (\in_array($fieldData['key'] ?? null, $existingKeys)) {
                unset($fields[$key]['key']);
            }

            if (isset($fieldData['id'])) {
                $existingIds[] = $fieldData['id'];
            }

            if (isset($fieldData['key'])) {
                $existingKeys[] = $fieldData['key'];
            }
        }

        $reservedKeys = \array_values(\array_filter(\array_column($fields, 'key'), 'is_string'));

        $counter = 0;

        foreach ($fields as $fieldData) {
            if (!\is_array($fieldData)) {
                continue;
            }
            ++$counter;
            $fieldType = self::getStringValue($fieldData, 'type') ?? '';
            $fieldKey = self::getStringValue($fieldData, 'key');

            $field = $form->getField($fieldKey);
            $uniqueKey = $this->getUniqueKey($fieldType, $reservedKeys);

            if (!$field) {
                $field = $form->getField($uniqueKey);
            }

            if (!$field) {
                $field = new FormField();
                $field->setKey($uniqueKey);
            } elseif ($field->getType() !== $fieldType || !$field->getKey()) {
                $field->setKey($uniqueKey);
            }

            if (!\in_array($field->getKey(), $reservedKeys)) {
                $reservedKeys[] = $field->getKey();
            }

            $field->setOrder($counter);
            $field->setType($fieldType);
            $field->setWidth(self::getStringValue($fieldData, 'width') ?? 'full');
            $field->setRequired(self::getBoolValue($fieldData, 'required'));

            $fieldTranslation = $field->getTranslation($locale, true);
            $fieldTranslation->setTitle(self::getStringValue($fieldData, 'title'));
            $fieldTranslation->setPlaceholder(self::getStringValue($fieldData, 'placeholder'));
            $fieldTranslation->setDefaultValue(self::getStringValue($fieldData, 'defaultValue'));
            $fieldTranslation->setShortTitle(self::getStringValue($fieldData, 'shortTitle'));
            $fieldTranslation->setOptions(self::getArrayValue($fieldData, 'options'));

            // Add Translation to Field
            if (!$fieldTranslation->getId()) {
                $fieldTranslation->setField($field);
                $field->addTranslation($fieldTranslation);
            }

            // Add Field to Form
            if (!$field->getId()) {
                $field->setDefaultLocale($locale);
                $field->setForm($form);
                $form->addField($field);
            }
        }

        // Remove Fields
        foreach ($form->getFieldsNotInArray($reservedKeys) as $deletedField) {
            $form->removeField($deletedField);
            $this->entityManager->remove($deletedField);
        }
    }

    /**
     * @param mixed[] $data
     * @param null|mixed $default
     *
     * @return mixed
     */
    protected static function getValue(array $data, string $value, $default = null, ?string $type = null)
    {
        if (isset($data[$value])) {
            if ('date' === $type) {
                if (!$data[$value]) {
                    return $default;
                }

                return new \DateTime($data[$value]);
            }

            return $data[$value];
        }

        return $default;
    }

    /**
     * @param mixed[] $data
     */
    private static function getStringValue(array $data, string $key, ?string $default = null): ?string
    {
        $value = $data[$key] ?? null;

        if (\is_scalar($value)) {
            return (string) $value;
        }

        return $default;
    }

    /**
     * @param mixed[] $data
     */
    private static function getBoolValue(array $data, string $key, bool $default = false): bool
    {
        $value = $data[$key] ?? null;

        if (null === $value) {
            return $default;
        }

        return (bool) $value;
    }

    /**
     * @param mixed[] $data
     *
     * @return mixed[]|null
     */
    private static function getArrayValue(array $data, string $key): ?array
    {
        $value = $data[$key] ?? null;

        return \is_array($value) ? $value : null;
    }

    /**
     * @param string[] $keys
     */
    protected function getUniqueKey(string $type, array $keys, int $counter = 0): string
    {
        $name = $type;

        if ($counter) {
            $name .= $counter;
        }

        if (!\in_array($name, $keys)) {
            return $name;
        }

        return $this->getUniqueKey($type, $keys, ++$counter);
    }
}

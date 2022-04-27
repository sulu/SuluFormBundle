<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Trash;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\ActivityBundle\Application\Collector\DomainEventCollectorInterface;
use Sulu\Bundle\FormBundle\Admin\FormAdmin;
use Sulu\Bundle\FormBundle\Domain\Event\FormRestoredEvent;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Sulu\Bundle\FormBundle\Entity\FormFieldTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Entity\FormTranslationReceiver;
use Sulu\Bundle\TrashBundle\Application\DoctrineRestoreHelper\DoctrineRestoreHelperInterface;
use Sulu\Bundle\TrashBundle\Application\RestoreConfigurationProvider\RestoreConfiguration;
use Sulu\Bundle\TrashBundle\Application\RestoreConfigurationProvider\RestoreConfigurationProviderInterface;
use Sulu\Bundle\TrashBundle\Application\TrashItemHandler\RestoreTrashItemHandlerInterface;
use Sulu\Bundle\TrashBundle\Application\TrashItemHandler\StoreTrashItemHandlerInterface;
use Sulu\Bundle\TrashBundle\Domain\Model\TrashItemInterface;
use Sulu\Bundle\TrashBundle\Domain\Repository\TrashItemRepositoryInterface;
use Sulu\Component\Security\Authentication\UserInterface;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type FormTrashItemData array{
 *     defaultLocale: string,
 *     translations: array<array{
 *         title: string,
 *         subject: string,
 *         fromEmail: string,
 *         fromName: string,
 *         toEmail: string,
 *         toName: string,
 *         mailText: string,
 *         submitLabel: string,
 *         successText: string,
 *         sendAttachments: bool,
 *         deactivateAttachmentSave: bool,
 *         deactivateNotifyMails: bool,
 *         deactivateCustomerMails: bool,
 *         replyTo: bool,
 *         locale: string,
 *         created: string,
 *         creatorId: string,
 *         receivers: array<array{
 *             type: string,
 *             email: string,
 *             name: string,
 *         }>,
 *     }>,
 *     fields: array<array{
 *         key: string,
 *         type: string,
 *         width: string,
 *         required: bool,
 *         order: int,
 *         defaultLocale: string,
 *         translations: array<array{
 *             title: string,
 *             locale: string,
 *             placeholder: string,
 *             defaultValue: string,
 *             shortTitle: string,
 *             options: mixed[],
 *         }>,
 *     }>,
 * }
 */
final class FormTrashItemHandler implements
    StoreTrashItemHandlerInterface,
    RestoreTrashItemHandlerInterface,
    RestoreConfigurationProviderInterface
{
    /**
     * @var TrashItemRepositoryInterface
     */
    private $trashItemRepository;

    /**
     * @var DoctrineRestoreHelperInterface
     */
    private $doctrineRestoreHelper;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var DomainEventCollectorInterface
     */
    private $domainEventCollector;

    public function __construct(
        TrashItemRepositoryInterface $trashItemRepository,
        EntityManagerInterface $entityManager,
        DoctrineRestoreHelperInterface $doctrineRestoreHelper,
        DomainEventCollectorInterface $domainEventCollector
    ) {
        $this->trashItemRepository = $trashItemRepository;
        $this->entityManager = $entityManager;
        $this->doctrineRestoreHelper = $doctrineRestoreHelper;
        $this->domainEventCollector = $domainEventCollector;
    }

    /**
     * @param Form $resource
     */
    public function store(object $resource, array $options = []): TrashItemInterface
    {
        Assert::isInstanceOf($resource, Form::class);

        /** @var FormTrashItemData $data */
        $data = [
            'defaultLocale' => $resource->getDefaultLocale(),
            'translations' => [],
            'fields' => [],
        ];
        $formTitles = [];

        foreach ($resource->getTranslations() as $translation) {
            $formTitles[$translation->getLocale()] = $translation->getTitle();
            $creator = $translation->getCreator();
            $translationData = [
                'title' => $translation->getTitle(),
                'subject' => $translation->getSubject(),
                'fromEmail' => $translation->getFromEmail(),
                'fromName' => $translation->getFromName(),
                'toEmail' => $translation->getToEmail(),
                'toName' => $translation->getToName(),
                'mailText' => $translation->getMailText(),
                'submitLabel' => $translation->getSubmitLabel(),
                'successText' => $translation->getSuccessText(),
                'sendAttachments' => $translation->getSendAttachments(),
                'deactivateAttachmentSave' => $translation->getDeactivateAttachmentSave(),
                'deactivateNotifyMails' => $translation->getDeactivateNotifyMails(),
                'deactivateCustomerMails' => $translation->getDeactivateCustomerMails(),
                'replyTo' => $translation->getReplyTo(),
                'locale' => $translation->getLocale(),
                'created' => $translation->getCreated()->format('c'),
                'creatorId' => $creator ? $creator->getId() : null,
                'receivers' => [],
            ];

            foreach ($translation->getReceivers() as $receiver) {
                $translationData['receivers'][] = [
                    'type' => $receiver->getType(),
                    'email' => $receiver->getEmail(),
                    'name' => $receiver->getName(),
                ];
            }

            $data['translations'][] = $translationData;
        }

        foreach ($resource->getFields() as $field) {
            $fieldData = [
                'key' => $field->getKey(),
                'type' => $field->getType(),
                'width' => $field->getWidth(),
                'required' => $field->getRequired(),
                'order' => $field->getOrder(),
                'defaultLocale' => $field->getDefaultLocale(),
                'translations' => [],
            ];

            foreach ($field->getTranslations() as $translation) {
                $fieldData['translations'][] = [
                    'title' => $translation->getTitle(),
                    'locale' => $translation->getLocale(),
                    'placeholder' => $translation->getPlaceholder(),
                    'defaultValue' => $translation->getDefaultValue(),
                    'shortTitle' => $translation->getShortTitle(),
                    'options' => $translation->getOptions(),
                ];
            }

            $data['fields'][] = $fieldData;
        }

        return $this->trashItemRepository->create(
            Form::RESOURCE_KEY,
            (string) $resource->getId(),
            $formTitles,
            \array_filter($data),
            null,
            $options,
            FormAdmin::SECURITY_CONTEXT,
            null,
            null
        );
    }

    public function restore(TrashItemInterface $trashItem, array $restoreFormData = []): object
    {
        $id = (int) $trashItem->getResourceId();
        /** @var FormTrashItemData $data */
        $data = $trashItem->getRestoreData();

        $form = new Form();
        $form->setDefaultLocale($data['defaultLocale']);

        foreach ($data['translations'] as $translationData) {
            /** @var FormTranslation $translation */
            $translation = $form->getTranslation($translationData['locale'], true);
            $translation->setTitle($translationData['title']);
            $translation->setSubject($translationData['subject']);
            $translation->setFromEmail($translationData['fromEmail']);
            $translation->setFromName($translationData['fromName']);
            $translation->setToEmail($translationData['toEmail']);
            $translation->setToName($translationData['toName']);
            $translation->setMailText($translationData['mailText']);
            $translation->setSubmitLabel($translationData['submitLabel']);
            $translation->setSuccessText($translationData['successText']);
            $translation->setSendAttachments($translationData['sendAttachments']);
            $translation->setDeactivateAttachmentSave($translationData['deactivateAttachmentSave']);
            $translation->setDeactivateNotifyMails($translationData['deactivateNotifyMails']);
            $translation->setDeactivateCustomerMails($translationData['deactivateCustomerMails']);
            $translation->setReplyTo($translationData['replyTo']);
            $translation->setCreated(new \DateTime($translationData['created']));
            $translation->setCreator($this->findEntity(UserInterface::class, $translationData['creatorId']));

            foreach ($translationData['receivers'] as $receiverData) {
                $receiver = new FormTranslationReceiver();
                $receiver->setType($receiverData['type']);
                $receiver->setEmail($receiverData['email']);
                $receiver->setName($receiverData['name']);

                $receiver->setFormTranslation($translation);
                $translation->addReceiver($receiver);
            }
        }

        foreach ($data['fields'] as $fieldData) {
            $field = new FormField();
            $field->setKey($fieldData['key']);
            $field->setType($fieldData['type']);
            $field->setWidth($fieldData['width']);
            $field->setRequired($fieldData['required']);
            $field->setOrder($fieldData['order']);
            $field->setDefaultLocale($fieldData['defaultLocale']);

            foreach ($fieldData['translations'] as $fieldTranslationData) {
                /** @var FormFieldTranslation $fieldTranslation */
                $fieldTranslation = $field->getTranslation($fieldTranslationData['locale'], true);
                $fieldTranslation->setTitle($fieldTranslationData['title']);
                $fieldTranslation->setPlaceholder($fieldTranslationData['placeholder']);
                $fieldTranslation->setDefaultValue($fieldTranslationData['defaultValue']);
                $fieldTranslation->setShortTitle($fieldTranslationData['shortTitle']);
                $fieldTranslation->setOptions($fieldTranslationData['options']);
            }

            $field->setForm($form);
            $form->addField($field);
        }

        $this->domainEventCollector->collect(new FormRestoredEvent($form, $data));

        if (null === $this->findEntity(Form::class, $id)) {
            $this->doctrineRestoreHelper->persistAndFlushWithId($form, $id);
        } else {
            $this->entityManager->persist($form);
            $this->entityManager->flush();
        }

        return $form;
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $className
     * @param mixed|null $id
     *
     * @return T|null
     */
    private function findEntity(string $className, $id)
    {
        if ($id) {
            return $this->entityManager->find($className, $id);
        }

        return null;
    }

    public function getConfiguration(): RestoreConfiguration
    {
        return new RestoreConfiguration(
            null,
            FormAdmin::EDIT_FORM_VIEW,
            ['id' => 'id']
        );
    }

    public static function getResourceKey(): string
    {
        return Form::RESOURCE_KEY;
    }
}

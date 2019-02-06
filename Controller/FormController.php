<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Manager\FormManager;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactory;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineCaseFieldDescriptor;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineDescriptor;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineFieldDescriptor;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineJoinDescriptor;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\RestHelperInterface;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Generated by https://github.com/alexander-schranz/sulu-backend-bundle.
 */
class FormController extends FOSRestController implements ClassResourceInterface, SecuredControllerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getSecurityContext()
    {
        return 'sulu.form.forms';
    }

    /**
     * @return FormManager
     */
    public function getManager()
    {
        return $this->get('sulu_form.manager.form');
    }

    /**
     * @param string $locale
     * @param array $filters
     *
     * @return DoctrineFieldDescriptor[] $filters
     */
    public function getFieldDescriptors($locale, $filters)
    {
        $fieldDescriptors = [];

        $fieldDescriptors['id'] = new DoctrineFieldDescriptor(
            'id',
            'id',
            Form::class,
            'public.id',
            [],
            true,
            false
        );

        $fieldDescriptors['title'] = new DoctrineCaseFieldDescriptor(
            'title',
            new DoctrineDescriptor(
                'translation',
                'title',
                [
                    'translation' => new DoctrineJoinDescriptor(
                        'translation',
                        Form::class . '.translations',
                        sprintf('translation.locale = \'%s\'', $locale)
                    ),
                ]
            ),
            new DoctrineDescriptor(
                'defaultTranslation',
                'title',
                [
                    'defaultTranslation' => new DoctrineJoinDescriptor(
                        'defaultTranslation',
                        Form::class . '.translations',
                        sprintf('defaultTranslation.locale = %s.defaultLocale', Form::class)
                    ),
                ]
            ),
            'public.title',
            false,
            true
        );

        $fieldDescriptors['changed'] = new DoctrineCaseFieldDescriptor(
            'changed',
            new DoctrineDescriptor(
                'translation',
                'changed',
                [
                    'translation' => new DoctrineJoinDescriptor(
                        'translation',
                        Form::class . '.translations',
                        sprintf('translation.locale = \'%s\'', $locale)
                    ),
                ]
            ),
            new DoctrineDescriptor(
                'defaultTranslation',
                'changed',
                [
                    'defaultTranslation' => new DoctrineJoinDescriptor(
                        'defaultTranslation',
                        Form::class . '.translations',
                        sprintf('defaultTranslation.locale = %s.defaultLocale', Form::class)
                    ),
                ]
            ),
            'public.changed',
            false,
            false
        );

        $fieldDescriptors['created'] = new DoctrineCaseFieldDescriptor(
            'created',
            new DoctrineDescriptor(
                'translation',
                'created',
                [
                    'translation' => new DoctrineJoinDescriptor(
                        'translation',
                        Form::class . '.translations',
                        sprintf('translation.locale = \'%s\'', $locale)
                    ),
                ]
            ),
            new DoctrineDescriptor(
                'defaultTranslation',
                'created',
                [
                    'defaultTranslation' => new DoctrineJoinDescriptor(
                        'defaultTranslation',
                        Form::class . '.translations',
                        sprintf('defaultTranslation.locale = %s.defaultLocale', Form::class)
                    ),
                ]
            ),
            'public.created',
            false,
            false
        );

        $fieldDescriptors['locale'] = new DoctrineCaseFieldDescriptor(
            'locale',
            new DoctrineDescriptor(
                'translation',
                'locale',
                [
                    'translation' => new DoctrineJoinDescriptor(
                        'translation',
                        Form::class . '.translations',
                        sprintf('translation.locale = \'%s\'', $locale)
                    ),
                ]
            ),
            new DoctrineDescriptor(
                'defaultTranslation',
                'locale',
                [
                    'defaultTranslation' => new DoctrineJoinDescriptor(
                        'defaultTranslation',
                        Form::class . '.translations',
                        sprintf('defaultTranslation.locale = %s.defaultLocale', Form::class)
                    ),
                ]
            ),
            'security.permission.role.language',
            true,
            false
        );

        return $fieldDescriptors;
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        return Form::class;
    }

    /**
     * @return string
     */
    public function getListName()
    {
        return 'forms';
    }

    /**
     * @return string
     */
    public function getBundleName()
    {
        return 'SuluFormBundle';
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function cgetFieldsAction(Request $request)
    {
        $fieldDescriptors = $this->getFieldDescriptors(
            $this->getLocale($request),
            $this->getFilters($request)
        );

        return $this->handleView($this->view($fieldDescriptors));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function cgetAction(Request $request)
    {
        $locale = $this->getLocale($request);
        $filters = $this->getFilters($request);

        // flatted entities
        if ('true' === $request->get('flat')) {
            /** @var RestHelperInterface $restHelper */
            $restHelper = $this->get('sulu_core.doctrine_rest_helper');

            /** @var DoctrineListBuilderFactory $factory */
            $factory = $this->get('sulu_core.doctrine_list_builder_factory');

            // get model class
            $listBuilder = $factory->create($this->getModelClass());

            // get fieldDescriptors
            $fieldDescriptors = $this->getFieldDescriptors($locale, $filters);
            $restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

            $listBuilder->addSelectField($fieldDescriptors['locale']);

            if ('true' !== $request->get('ghost')) {
                $listBuilder->where($fieldDescriptors['locale'], $locale);
            }

            // load entities
            $list = $listBuilder->execute();

            // get pagination
            $total = $listBuilder->count();
            $page = $listBuilder->getCurrentPage();
            $limit = $listBuilder->getLimit();
        } else {
            // load all entities by filters
            $list = $this->getManager()->findAll($locale, $filters);

            foreach ($list as $key => $entity) {
                $list[$key] = $this->getApiEntity($entity, $locale);
            }

            // get pagination
            $offset = $this->getOffset($filters);
            $limit = $this->getLimit($filters);
            $total = $offset + count($list);
            $page = $this->getPage($filters);

            // if to avoid db request with less items then the limit
            if (count($list) >= $limit) {
                $total = $this->getManager()->count($locale, $this->getCountFilters($filters));
            }
        }

        // create list representation
        $representation = new ListRepresentation(
            $list,
            $this->getListName(),
            $request->get('_route'),
            $request->query->all(),
            $page,
            $limit,
            $total
        );

        return $this->handleView($this->view($representation));
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function getAction(Request $request, $id)
    {
        $locale = $this->getLocale($request);

        $entity = $this->getManager()->findById($id, $locale);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('No form with id "%s" was found!', $id));
        }

        return $this->handleView($this->view($this->getApiEntity($entity, $locale)));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        $locale = $this->getLocale($request);

        // create entity
        $entity = $this->getManager()->save($this->getData($request), $locale);

        return $this->handleView($this->view($this->getApiEntity($entity, $locale), 201));
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function putAction(Request $request, $id)
    {
        $locale = $this->getLocale($request);

        // save entity
        $entity = $this->getManager()->save($this->getData($request), $locale, $id);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('No form with id "%s" was found!', $id));
        }

        return $this->handleView($this->view($this->getApiEntity($entity, $locale)));
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function deleteAction(Request $request, $id)
    {
        $locale = $this->getLocale($request);

        $entity = $this->getManager()->delete($id, $locale);

        if (!$entity) {
            throw $this->createNotFoundException(sprintf('No form with id "%s" was found!', $id));
        }

        return new Response('', 204);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(Request $request)
    {
        return $request->get('locale', $request->getLocale());
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getFilters(Request $request)
    {
        $filters = $request->query->all();

        $listRestHelper = $this->get('sulu_core.list_rest_helper');

        unset($filters['page']);
        unset($filters['limit']);
        unset($filters['fields']);
        unset($filters['search']);
        unset($filters['searchFields']);
        unset($filters['locale']);
        unset($filters['flat']);

        $filters['fields'] = $listRestHelper->getFields();
        $filters['limit'] = (int) $listRestHelper->getLimit();
        $filters['offset'] = (int) $listRestHelper->getOffset();
        $filters['sortColumn'] = $listRestHelper->getSortColumn();
        $filters['sortOrder'] = $listRestHelper->getSortOrder();
        $filters['searchFields'] = $listRestHelper->getSearchFields();
        $filters['searchPattern'] = $listRestHelper->getSearchPattern();

        return $filters;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getData(Request $request)
    {
        return $request->request->all();
    }

    /**
     * @param array $filters
     *
     * @return array
     */
    protected function getCountFilters($filters)
    {
        unset($filters['page']);
        unset($filters['offset']);
        unset($filters['limit']);

        return $filters;
    }

    /**
     * @param array $filters
     *
     * @return int
     */
    protected function getLimit($filters)
    {
        if (!isset($filters['limit'])) {
            return 10;
        }

        return $filters['limit'];
    }

    /**
     * @param array $filters
     *
     * @return int
     */
    protected function getOffset($filters)
    {
        if (!isset($filters['offset'])) {
            return 0;
        }

        return $filters['offset'];
    }

    /**
     * @param array $filters
     *
     * @return int
     */
    protected function getPage($filters)
    {
        if (!isset($filters['page'])) {
            if (isset($filters['limit']) && isset($filters['offset'])) {
                return floor($filters['offset'] / $filters['limit']) + 1;
            }

            return 1;
        }

        return $filters['page'];
    }

    /**
     * TODO use seralizer.
     *
     * @param Form $entity
     * @param string $locale
     *
     * @return array
     */
    private function getApiEntity(Form $entity, $locale)
    {
        // Translation
        $translation = $entity->getTranslation($locale);

        $translations = [];

        if ($translation) {
            $receivers = [];

            foreach ($translation->getReceivers() as $receiver) {
                $receivers[] = [
                    'id' => $receiver->getId(),
                    'name' => $receiver->getName(),
                    'email' => $receiver->getEmail(),
                    'type' => $receiver->getType(),
                ];
            }

            $translations = [
                'title' => $translation->getTitle(),
                'fromEmail' => $translation->getFromEmail(),
                'fromName' => $translation->getFromName(),
                'toEmail' => $translation->getToEmail(),
                'toName' => $translation->getToName(),
                'subject' => $translation->getSubject(),
                'mailText' => $translation->getMailText(),
                'submitLabel' => $translation->getSubmitLabel(),
                'successText' => $translation->getSuccessText(),
                'sendAttachments' => $translation->getSendAttachments(),
                'deactivateNotifyMails' => $translation->getDeactivateNotifyMails(),
                'deactivateCustomerMails' => $translation->getDeactivateCustomerMails(),
                'receivers' => $receivers,
                'replyTo' => $translation->getReplyTo(),
            ];
        }

        // Fields
        $fields = [];

        foreach ($entity->getFields() as $field) {
            $fieldTranslation = $field->getTranslation($locale);

            $fieldData = [
                'id' => $field->getId(),
                'type' => $field->getType(),
                'key' => $field->getKey(),
                'required' => $field->getRequired(),
                'order' => $field->getOrder(),
                'width' => $field->getWidth(),
            ];

            if ($fieldTranslation) {
                $fieldData['title'] = $fieldTranslation->getTitle();
                $fieldData['placeholder'] = $fieldTranslation->getPlaceholder();
                $fieldData['defaultValue'] = $fieldTranslation->getDefaultValue();
                $fieldData['shortTitle'] = $fieldTranslation->getShortTitle();

                foreach ($fieldTranslation->getOptions() as $key => $option) {
                    $fieldData['options[' . $key . ']'] = $option;
                }
            }

            $fields[] = $fieldData;
        }

        // Api Entity
        return array_merge(
            [
                'id' => $entity->getId(),
                'locale' => $locale,
                'fields' => $fields,
            ],
            $translations
        );
    }
}

<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Bundle\FormBundle\Admin\FormAdmin;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Exception\FormNotFoundException;
use Sulu\Bundle\FormBundle\Manager\FormManager;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\Exception\RestException;
use Sulu\Component\Rest\ListBuilder\AbstractListBuilder;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\ListBuilder\ListRestHelperInterface;
use Sulu\Component\Rest\ListBuilder\Metadata\FieldDescriptorFactoryInterface;
use Sulu\Component\Rest\RestHelperInterface;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FormController extends AbstractRestController implements ClassResourceInterface, SecuredControllerInterface
{
    /**
     * @var FormManager
     */
    private $formManager;

    /**
     * @var RestHelperInterface
     */
    private $restHelper;

    /**
     * @var DoctrineListBuilderFactoryInterface
     */
    private $factory;

    /**
     * @var FieldDescriptorFactoryInterface
     */
    private $fieldDescriptorFactory;

    /**
     * @var ListRestHelperInterface
     */
    private $listRestHelper;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        TokenStorageInterface $tokenStorage,
        FormManager $formManager,
        RestHelperInterface $restHelper,
        DoctrineListBuilderFactoryInterface $factory,
        FieldDescriptorFactoryInterface $fieldDescriptorFactory,
        ListRestHelperInterface $listRestHelper
    ) {
        parent::__construct($viewHandler, $tokenStorage);
        $this->formManager = $formManager;
        $this->restHelper = $restHelper;
        $this->factory = $factory;
        $this->fieldDescriptorFactory = $fieldDescriptorFactory;
        $this->listRestHelper = $listRestHelper;
    }

    /**
     * @return string
     */
    public function getSecurityContext()
    {
        return FormAdmin::SECURITY_CONTEXT;
    }

    public function getModelClass(): string
    {
        return Form::class;
    }

    public function getListName(): string
    {
        return 'forms';
    }

    public function cgetAction(Request $request): Response
    {
        $locale = $this->getLocale($request);
        $filters = $this->getFilters($request);

        // flatted entities
        if ('true' === $request->get('flat')) {
            // get model class
            /** @var AbstractListBuilder $listBuilder */
            $listBuilder = $this->factory->create($this->getModelClass());

            // get fieldDescriptors
            $fieldDescriptors = $this->fieldDescriptorFactory->getFieldDescriptors(Form::RESOURCE_KEY);

            $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

            $listBuilder->setParameter('locale', $locale);

            // load entities
            $list = $listBuilder->execute();

            // get pagination
            $total = $listBuilder->count();
            $page = $listBuilder->getCurrentPage();
            $limit = $listBuilder->getLimit();
        } else {
            // load all entities by filters
            $list = $this->formManager->findAll($locale, $filters);

            foreach ($list as $key => $entity) {
                $list[$key] = $this->getApiEntity($entity, $locale);
            }

            // get pagination
            $offset = $this->getOffset($filters);
            $limit = $this->getLimit($filters);
            $total = $offset + \count($list);
            $page = $this->getPage($filters);

            // if to avoid db request with less items then the limit
            if (\count($list) >= $limit) {
                $total = $this->formManager->count($locale, $this->getCountFilters($filters));
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

    public function getAction(Request $request, int $id): Response
    {
        $locale = $this->getLocale($request);

        $entity = $this->formManager->findById($id, $locale);

        if (!$entity) {
            throw new NotFoundHttpException(\sprintf('No form with id "%s" was found!', $id));
        }

        return $this->handleView($this->view($this->getApiEntity($entity, $locale)));
    }

    public function postAction(Request $request): Response
    {
        $locale = $this->getLocale($request);

        // create entity
        $entity = $this->formManager->save($this->getData($request), $locale);

        return $this->handleView($this->view($this->getApiEntity($entity, $locale), 201));
    }

    public function postTriggerAction(Request $request, int $id): Response
    {
        $action = $request->query->get('action');
        $locale = $this->getLocale($request);

        try {
            switch ($action) {
                case 'copy':
                    try {
                        $copiedForm = $this->formManager->copy($id, $locale);
                    } catch (FormNotFoundException $e) {
                        throw new NotFoundHttpException(\sprintf('No form with id "%s" was found!', $e->getFormEntityId()), $e);
                    }

                    return $this->handleView($this->view($this->getApiEntity($copiedForm, $locale)));
                default:
                    throw new RestException(\sprintf('Unrecognized action: "%s"', $action));
            }
        } catch (RestException $ex) {
            $view = $this->view($ex->toArray(), 400);

            return $this->handleView($view);
        }
    }

    public function putAction(Request $request, int $id): Response
    {
        $locale = $this->getLocale($request);

        // save entity
        $entity = $this->formManager->save($this->getData($request), $locale, $id);

        if (!$entity) {
            throw new NotFoundHttpException(\sprintf('No form with id "%s" was found!', $id));
        }

        return $this->handleView($this->view($this->getApiEntity($entity, $locale)));
    }

    public function deleteAction(Request $request, int $id): Response
    {
        $locale = $this->getLocale($request);

        $entity = $this->formManager->delete($id, $locale);

        if (!$entity) {
            throw new NotFoundHttpException(\sprintf('No form with id "%s" was found!', $id));
        }

        return new Response('', 204);
    }

    public function getLocale(Request $request): string
    {
        return $request->get('locale', $request->getLocale());
    }

    /**
     * @return mixed[]
     */
    protected function getFilters(Request $request): array
    {
        $filters = $request->query->all();

        unset($filters['page']);
        unset($filters['limit']);
        unset($filters['fields']);
        unset($filters['search']);
        unset($filters['searchFields']);
        unset($filters['locale']);
        unset($filters['flat']);

        $filters['fields'] = $this->listRestHelper->getFields();
        $filters['limit'] = (int) $this->listRestHelper->getLimit();
        $filters['offset'] = (int) $this->listRestHelper->getOffset();
        $filters['sortColumn'] = $this->listRestHelper->getSortColumn();
        $filters['sortOrder'] = $this->listRestHelper->getSortOrder();
        $filters['searchFields'] = $this->listRestHelper->getSearchFields();
        $filters['searchPattern'] = $this->listRestHelper->getSearchPattern();

        return $filters;
    }

    /**
     * @return mixed[]
     */
    protected function getData(Request $request): array
    {
        return $request->request->all();
    }

    /**
     * @param mixed[] $filters
     *
     * @return mixed[]
     */
    protected function getCountFilters(array $filters): array
    {
        unset($filters['page']);
        unset($filters['offset']);
        unset($filters['limit']);

        return $filters;
    }

    /**
     * @param mixed[] $filters
     */
    protected function getLimit(array $filters): int
    {
        if (!isset($filters['limit'])) {
            return 10;
        }

        return $filters['limit'];
    }

    /**
     * @param mixed[] $filters
     */
    protected function getOffset(array $filters): int
    {
        if (!isset($filters['offset'])) {
            return 0;
        }

        return $filters['offset'];
    }

    /**
     * @param mixed[] $filters
     */
    protected function getPage(array $filters): int
    {
        if (!isset($filters['page'])) {
            if (isset($filters['limit']) && isset($filters['offset'])) {
                return \intval(\floor($filters['offset'] / $filters['limit']) + 1);
            }

            return 1;
        }

        return $filters['page'];
    }

    /**
     * TODO use seralizer.
     *
     * @return mixed[]
     */
    private function getApiEntity(Form $entity, string $locale): array
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
                'deactivateAttachmentSave' => $translation->getDeactivateAttachmentSave(),
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
                $fieldData['options'] = $fieldTranslation->getOptions();
            }

            if (empty($fieldData['options'])) {
                $fieldData['options'] = new \stdClass(); // convert options to "{}"
            }

            $fields[] = $fieldData;
        }

        // Sort fields with correct order
        \usort($fields, function($fieldA, $fieldB) {
            return $fieldA['order'] <=> $fieldB['order'];
        });

        // Api Entity
        return \array_merge(
            [
                'id' => $entity->getId(),
                'locale' => $locale,
                'fields' => $fields,
            ],
            $translations
        );
    }
}

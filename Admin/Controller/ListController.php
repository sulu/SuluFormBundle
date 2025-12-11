<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Admin\Controller;

use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Bundle\FormBundle\Provider\ListProviderRegistry;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ListController extends AbstractRestController
{
    public function __construct(
        ViewHandlerInterface $viewHandler,
        TokenStorageInterface $tokenStorage,
        private RestHelperInterface $restHelper,
        private DoctrineListBuilderFactoryInterface $listBuilderFactory,
        private ListProviderRegistry $providerRegistry
    ) {
        parent::__construct($viewHandler, $tokenStorage);
    }

    public function cgetFieldsAction(Request $request): Response
    {
        $template = $request->query->getString('template');
        $locale = $request->query->getString('locale');
        $webspace = $request->query->getString('webspace');
        $uuid = $request->query->getString('uuid');

        if (!$template) {
            throw new NotFoundHttpException('"template" is required parameter!');
        }

        $fieldDescriptors = $this->providerRegistry->getFieldDescriptors($template, $webspace, $locale, $uuid);

        return $this->handleView($this->view(\array_values($fieldDescriptors)));
    }

    public function cgetAction(Request $request): Response
    {
        $template = $request->query->getString('template');
        $webspace = $request->query->getString('webspace');
        $locale = $request->query->getString('locale');
        $uuid = $request->query->getString('uuid');

        if (!$template) {
            throw new NotFoundHttpException('"template" is required parameter');
        }

        $fieldDescriptors = $this->providerRegistry->getFieldDescriptors($template, $webspace, $locale, $uuid);
        $entityName = $this->providerRegistry->getEntityName($template, $webspace, $locale, $uuid);

        // get model class
        $listBuilder = $this->listBuilderFactory->create($entityName);

        // add filters
        if (isset($fieldDescriptors['uuid'])) {
            $listBuilder->where($fieldDescriptors['uuid'], $uuid);
        }
        if (isset($fieldDescriptors['webspaceKey'])) {
            $listBuilder->where($fieldDescriptors['webspaceKey'], $webspace);
        }
        if (isset($fieldDescriptors['template'])) {
            $listBuilder->where($fieldDescriptors['template'], $template);
        }

        // Init List Builder
        $this->restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

        // load entities
        $list = $listBuilder->execute();

        // get pagination
        $total = $listBuilder->count();
        $page = $listBuilder->getCurrentPage();
        $limit = $listBuilder->getLimit();

        // create list representation
        $representation = new PaginatedRepresentation(
            $list,
            'entries',
            $page,
            $limit,
            $total
        );

        return $this->handleView($this->view($representation));
    }
}

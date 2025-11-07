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
use Sulu\Bundle\FormBundle\Provider\ListProviderRegistry;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactoryInterface;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ListController extends AbstractRestController implements ClassResourceInterface
{
    /**
     * @var RestHelperInterface
     */
    private $restHelper;

    /**
     * @var DoctrineListBuilderFactoryInterface
     */
    private $listBuilderFactory;

    /**
     * @var ListProviderRegistry
     */
    private $providerRegistry;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        TokenStorageInterface $tokenStorage,
        RestHelperInterface $restHelper,
        DoctrineListBuilderFactoryInterface $listBuilderFactory,
        ListProviderRegistry $providerRegistry
    ) {
        parent::__construct($viewHandler, $tokenStorage);
        $this->restHelper = $restHelper;
        $this->listBuilderFactory = $listBuilderFactory;
        $this->providerRegistry = $providerRegistry;
    }

    public function cgetFieldsAction(Request $request): Response
    {
        $template = $request->get('template');
        $locale = $request->get('locale');
        $webspace = $request->get('webspace');
        $uuid = $request->get('uuid');

        if (!$template) {
            throw new NotFoundHttpException('"template" is required parameter!');
        }

        $fieldDescriptors = $this->providerRegistry->getFieldDescriptors($template, $webspace, $locale, $uuid);

        return $this->handleView($this->view(\array_values($fieldDescriptors)));
    }

    public function cgetAction(Request $request): Response
    {
        $template = $request->get('template');
        $webspace = $request->get('webspace');
        $locale = $request->get('locale');
        $uuid = $request->get('uuid');

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
        $representation = new ListRepresentation(
            $list,
            'entries',
            $request->get('_route'),
            $request->query->all(),
            $page,
            $limit,
            $total
        );

        return $this->handleView($this->view($representation));
    }
}

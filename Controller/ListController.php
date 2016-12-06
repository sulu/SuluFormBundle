<?php

namespace L91\Sulu\Bundle\FormBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Sulu\Component\Rest\ListBuilder\Doctrine\DoctrineListBuilderFactory;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\RestController;
use Sulu\Component\Rest\RestHelperInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListController extends RestController implements ClassResourceInterface
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgetFieldsAction(Request $request)
    {
        $template = $request->get('template');
        $locale = $request->get('locale');
        $webspace = $request->get('webspace');
        $uuid = $request->get('uuid');

        if (!$template) {
            throw new NotFoundHttpException('"template" is required parameter!');
        }

        $fieldDescriptors = $this->getProviderRegistry()->getFieldDescriptors($template, $webspace, $locale, $uuid);

        return $this->handleView($this->view(array_values($fieldDescriptors)));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgetAction(Request $request)
    {
        $template = $request->get('template');
        $webspace = $request->get('webspace');
        $locale = $request->get('locale');
        $uuid = $request->get('uuid');

        if (!$template) {
            throw new NotFoundHttpException('"template" is required parameter');
        }

        $fieldDescriptors = $this->getProviderRegistry()->getFieldDescriptors($template, $webspace, $locale, $uuid);
        $entityName = $this->getProviderRegistry()->getEntityName($template, $webspace, $locale, $uuid);

        /** @var RestHelperInterface $restHelper */
        $restHelper = $this->get('sulu_core.doctrine_rest_helper');

        /** @var DoctrineListBuilderFactory $factory */
        $factory = $this->get('sulu_core.doctrine_list_builder_factory');

        // get model class
        $listBuilder = $factory->create($entityName);

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
        $restHelper->initializeListBuilder($listBuilder, $fieldDescriptors);

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

    /**
     * @return \L91\Sulu\Bundle\FormBundle\Provider\ListProviderRegistry
     */
    protected function getProviderRegistry()
    {
        return $this->get('l91.sulu.list.provider.registry');
    }
}

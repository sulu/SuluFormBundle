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

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\ViewHandler;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\ListBuilder\DynamicListFactory;
use Sulu\Bundle\FormBundle\Repository\DynamicRepository;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use Sulu\Bundle\MediaBundle\Media\Manager\MediaManagerInterface;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Controller to create dynamic form entries list.
 */
class DynamicController implements ClassResourceInterface
{
    use ControllerTrait;

    /**
     * @var DynamicRepository
     */
    private $dynamicRepository;

    /**
     * @var DynamicListFactory
     */
    private $dynamicListFactory;

    /**
     * @var MediaManagerInterface
     */
    private $mediaManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var FormRepository
     */
    private $formRepository;

    /**
     * @var ViewHandler
     */
    private $viewHandler;

    public function __construct(
        DynamicRepository $dynamicRepository,
        DynamicListFactory $dynamicListFactory,
        MediaManagerInterface $mediaManager,
        EntityManager $entityManager,
        FormRepository $formRepository,
        ViewHandler $viewHandler
    ) {
        $this->dynamicRepository = $dynamicRepository;
        $this->dynamicListFactory = $dynamicListFactory;
        $this->mediaManager = $mediaManager;
        $this->entityManager = $entityManager;
        $this->formRepository = $formRepository;
        $this->viewHandler = $viewHandler;
    }

    /**
     * Return dynamic form entries.
     */
    public function cgetAction(Request $request): Response
    {
        $filters = $this->getFilters($request);
        $page = $request->get('page', 1);
        $limit = $request->get('limit');
        $offset = (int) (($page - 1) * $limit);
        $view = $request->get('view', 'default');
        $sortOrder = $request->get('sortOrder', 'asc');
        $sortBy = $request->get('sortBy', 'created');

        $entries = $this->dynamicRepository->findByFilters(
            $filters,
            [$sortBy => $sortOrder],
            $limit,
            $offset
        );

        $entries = $this->dynamicListFactory->build($entries, $view);

        // avoid total request when entries < limit
        if (\count($entries) == $limit) {
            $total = $this->dynamicRepository->countByFilters($filters);
        } else {
            // calculate total
            $total = \count($entries) + $offset;
        }

        // create list representation
        $representation = new ListRepresentation(
            $entries,
            'dynamic_forms',
            $request->get('_route'),
            $request->query->all(),
            $page,
            $limit,
            $total
        );

        return $this->viewHandler->handle($this->view($representation));
    }

    /**
     * Delete dynamic form entry.
     */
    public function deleteAction(Request $request, int $id): Response
    {
        $dynamic = $this->dynamicRepository->find($id);

        $attachments = \array_filter(\array_values($dynamic->getFieldsByType(Dynamic::TYPE_ATTACHMENT)));

        foreach ($attachments as $mediaIds) {
            foreach ($mediaIds as $mediaId) {
                if ($mediaId) {
                    try {
                        $this->mediaManager->delete($mediaId);
                    } catch (MediaNotFoundException $e) {
                        // Do nothing when media was removed before.
                        // @ignoreException
                    }
                }
            }
        }
        $this->entityManager->remove($dynamic);
        $this->entityManager->flush();

        return new Response('', 204);
    }

    /**
     * @return mixed[]
     */
    protected function getFilters(Request $request): array
    {
        $filters = [
            'type' => $request->get('type'),
            'typeId' => $request->get('typeId'),
            'webspaceKey' => $request->get('webspaceKey'),
            'form' => $request->get('form'),
            'fromDate' => $request->get('fromDate'),
            'toDate' => $request->get('toDate'),
            'search' => $request->get('search'),
            'searchFields' => \array_filter(\explode(',', $request->get('searchFields', ''))),
        ];

        return \array_filter($filters);
    }

    protected function loadForm(Request $request): Form
    {
        $formId = (int) $request->get('form');

        if (!$formId) {
            throw new BadRequestHttpException('"form" is required parameter');
        }

        return $this->formRepository->loadById($formId);
    }

    public function getLocale(Request $request): ?string
    {
        return $request->get('locale', $request->getLocale());
    }
}

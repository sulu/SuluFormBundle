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
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
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
        $locale = $this->getLocale($request);
        $filters = $this->getFilters($request);
        $page = (int) $request->query->getInt('page', 1);
        $limit = (int) $request->query->getInt('limit');
        $offset = (int) (($page - 1) * $limit);
        /** @var string $view */
        $view = $request->query->get('view', 'default');
        /** @var string $sortOrder */
        $sortOrder = $request->query->get('sortOrder', 'asc');
        /** @var string $sortBy */
        $sortBy = $request->query->get('sortBy', 'created');

        $entries = $this->dynamicRepository->findByFilters(
            $filters,
            [$sortBy => $sortOrder],
            $limit,
            $offset
        );

        $entries = $this->dynamicListFactory->build($entries, $locale, $view);

        // avoid total request when entries < limit
        if (\count($entries) == $limit) {
            $total = $this->dynamicRepository->countByFilters($filters);
        } else {
            // calculate total
            $total = \count($entries) + $offset;
        }

        $representation = new PaginatedRepresentation(
            $entries,
            'dynamic_forms',
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

        if (!$dynamic) {
            return new Response('', 204);
        }

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
            'type' => $request->query->get('type'),
            'typeId' => $request->query->get('typeId'),
            'webspaceKey' => $request->query->get('webspaceKey'),
            'form' => $request->query->get('form'),
            'fromDate' => $request->query->get('fromDate'),
            'toDate' => $request->query->get('toDate'),
            'search' => $request->query->get('search'),
            'searchFields' => \array_filter(\explode(',', $request->query->get('fields', ''))),
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

    public function getLocale(Request $request): string
    {
        return $request->query->get('locale', $request->getLocale());
    }
}

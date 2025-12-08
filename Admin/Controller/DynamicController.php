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

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\View\ViewHandler;
use Sulu\Bundle\FormBundle\Admin\ListBuilder\DynamicListFactoryInterface;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
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
class DynamicController
{
    use ControllerTrait;

    public function __construct(
        private DynamicRepository $dynamicRepository,
        private DynamicListFactoryInterface $dynamicListFactory,
        private MediaManagerInterface $mediaManager,
        private EntityManager $entityManager,
        private FormRepository $formRepository,
        private ViewHandler $viewHandler
    ) {
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

        $view = $request->query->getString('view', 'default');
        $sortOrder = $request->query->getString('sortOrder', 'asc');
        $sortBy = $request->query->getString('sortBy', 'created');

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

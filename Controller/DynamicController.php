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

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Repository\DynamicRepository;
use Sulu\Bundle\MediaBundle\Media\Exception\MediaNotFoundException;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\RestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Controller to create dynamic form entries list.
 */
class DynamicController extends RestController implements ClassResourceInterface
{
    /**
     * Return dynamic form entries.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function cgetAction(Request $request)
    {
        /** @var DynamicRepository $repository */
        $repository = $this->get('sulu_form.repository.dynamic');

        $filters = $this->getFilters($request);
        $page = $request->get('page', 1);
        $limit = $request->get('limit');
        $offset = (($page - 1) * $limit);
        $view = $request->get('view', 'default');
        $sortOrder = $request->get('sortOrder', 'asc');
        $sortBy = $request->get('sortBy', 'created');

        $entries = $repository->findByFilters(
            $filters,
            [$sortBy => $sortOrder],
            $limit,
            $offset
        );

        $entries = $this->get('sulu_form.list_builder.dynamic_list_factory')->build($entries, $view);

        // avoid total request when entries < limit
        if (count($entries) == $limit) {
            $total = $repository->countByFilters($filters);
        } else {
            // calculate total
            $total = count($entries) + $offset;
        }

        // create list representation
        $representation = new ListRepresentation(
            $entries,
            'dynamics',
            $request->get('_route'),
            $request->query->all(),
            $page,
            $limit,
            $total
        );

        return $this->handleView($this->view($representation));
    }

    /**
     * Returns the fields for a dynamic form.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function cgetFieldsAction(Request $request)
    {
        $form = $this->loadForm($request);
        $fieldDescriptors = [];

        if ($form) {
            $locale = $this->getLocale($request);
            $fieldDescriptors = $this->get('sulu_form.list_builder.dynamic_list_factory')
                ->getFieldDescriptors($form, $locale);
        }

        return $this->handleView($this->view(array_values($fieldDescriptors)));
    }

    /**
     * Delete dynamic form entry.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAction(Request $request, $id)
    {
        $mediaManager = $this->get('sulu_media.media_manager');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');

        /** @var DynamicRepository $repository */
        $repository = $this->get('sulu_form.repository.dynamic');

        /** @var Dynamic $dynamic */
        $dynamic = $repository->find($id);

        $attachments = array_values($dynamic->getFieldsByType(Dynamic::TYPE_ATTACHMENT));

        foreach ($attachments as $mediaIds) {
            foreach ($mediaIds as $mediaId) {
                if ($mediaId) {
                    try {
                        $mediaManager->delete($mediaId);
                    } catch (MediaNotFoundException $e) {
                        // Do nothing when meida was removed before.
                    }
                }
            }
        }
        $entityManager->remove($dynamic);
        $entityManager->flush();

        return new Response('', 204);
    }

    /**
     * Get filters.
     *
     * @param Request $request
     *
     * @return array
     */
    protected function getFilters(Request $request)
    {
        $filters = [
            'type' => $request->get('type'),
            'typeId' => $request->get('typeId'),
            'webspaceKey' => $request->get('webspaceKey'),
            'form' => $request->get('form'),
            'fromDate' => $request->get('fromDate'),
            'toDate' => $request->get('toDate'),
            'search' => $request->get('search'),
            'searchFields' => array_filter(explode(',', $request->get('searchFields', ''))),
        ];

        return array_filter($filters);
    }

    /**
     * Get form.
     *
     * @param Request $request
     *
     * @return Form
     */
    protected function loadForm(Request $request)
    {
        $formId = (int) $request->get('form');

        if (!$formId) {
            throw new BadRequestHttpException('"form" is required parameter');
        }

        return $this->get('sulu_form.repository.form')->loadById($formId);
    }
}

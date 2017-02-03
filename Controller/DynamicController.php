<?php

namespace Sulu\Bundle\FormBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Sulu\Bundle\FormBundle\Entity\Form;
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
        $repository = $this->get('sulu_form.repository.dynamic');

        $filters = $this->getFilters($request);
        $page = $request->get('page', 1);
        $limit = $request->get('limit');
        $offset = (($page - 1) * $limit);
        $view = $request->get('view', 'default');
        $sortOrder = $request->get('sortOrder', 'asc');
        $sortBy = $request->get('sortBy', 'created');

        $entries = $repository->findBy(
            $filters,
            [$sortBy => $sortOrder],
            $limit,
            $offset
        );

        $entries = $this->get('sulu_form.list_builder.dynamic_list_factory')->build($entries, $view);

        // avoid total request when entries < limit
        if (count($entries) == $limit) {
            $total = count($repository->findBy($filters));
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
        $locale = $request->getLocale();

        $fieldDescriptors = $this->get('sulu_form.list_builder.dynamic_list_factory')
            ->getFieldDescriptors($form, $locale);

        return $this->handleView($this->view(array_values($fieldDescriptors)));
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
            'uuid' => $request->get('uuid'),
            'webspaceKey' => $request->get('webspaceKey'),
            'form' => $request->get('form'),
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

        return $this->get('sulu_form.repository.form')->findById($formId);
    }
}

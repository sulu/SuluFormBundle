<?php

namespace Sulu\Bundle\FormBundle\Form;

use Symfony\Component\HttpFoundation\Request;

/**
 * Define the method to builds dynamic form.
 */
interface BuilderInterface
{
    /**
     * Build by request.
     *
     * @param Request $request
     *
     * @return array
     *
     * @throws \Exception
     */
    public function buildByRequest(Request $request);

    /**
     * Build dynamic form.
     *
     * @param int $id
     * @param string $type
     * @param string $typeId
     * @param string $typeName
     * @param string $locale
     * @param string $name
     *
     * @return array
     */
    public function build($id, $type, $typeId, $typeName, $locale = null, $name = 'form');
}

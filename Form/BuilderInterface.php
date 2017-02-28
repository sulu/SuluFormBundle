<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

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
     * @param string $locale
     * @param string $name
     *
     * @return array
     */
    public function build($id, $type, $typeId, $locale = null, $name = 'form');
}

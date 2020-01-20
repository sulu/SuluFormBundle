<?php

/*
 * This file is part of Sulu.
 * (c) Sulu GmbH
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Define the method to builds dynamic form.
 */
interface BuilderInterface
{
    /**
     * Build by request.
     */
    public function buildByRequest(Request $request): ?FormInterface;

    /**
     * Build dynamic form.
     */
    public function build(int $id, string $type, string $typeId, ?string $locale = null, string $name = 'form'): FormInterface;
}

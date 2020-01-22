<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Exception;

class FormNotFoundException extends \Exception
{
    /**
     * @var string
     */
    private $formEntityId;

    public function __construct(string $formEntityId, $locale)
    {
        parent::__construct(sprintf('The form with the ID "%s" does not exist for the locale "%s"!', $formEntityId, $locale));

        $this->formEntityId = $formEntityId;
    }

    public function getFormEntityId(): string
    {
        return $this->formEntityId;
    }
}

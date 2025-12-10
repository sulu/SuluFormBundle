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

class BuilderNotFoundException extends \Exception
{
    /**
     * @param array<string> $availableBuilders
     */
    public function __construct(
        private string $builder,
        ?array $availableBuilders = null,
    ) {
        $availableBuildersInfo = '';
        if (null !== $availableBuilders) {
            $availableBuildersInfo = ' Known builders: ' . \join($availableBuilders);
        }

        parent::__construct(\sprintf('Builder with the name "%s" not found.%s', $builder, $availableBuildersInfo));

        $this->builder = $builder;
    }

    public function getBuilder(): string
    {
        return $this->builder;
    }
}

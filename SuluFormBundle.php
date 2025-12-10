<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle;

use Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass\DynamicListBuilderCompilerPass;
use Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass\ListProviderCompilerPass;
use Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass\RemoveTaggedServiceCollectorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SuluFormBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ListProviderCompilerPass());
        $container->addCompilerPass(new DynamicListBuilderCompilerPass());
        $container->addCompilerPass(new RemoveTaggedServiceCollectorCompilerPass(
            'sulu_form.dynamic.type',
            'alias',
            'sulu_form.dynamic_disabled_types'
        ));
    }
}

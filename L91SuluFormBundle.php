<?php

namespace L91\Sulu\Bundle\FormBundle;

use L91\Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass\DynamicListBuilderCompilerPass;
use L91\Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass\ListProviderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class L91SuluFormBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ListProviderCompilerPass());
        $container->addCompilerPass(new DynamicListBuilderCompilerPass());
    }
}

<?php

namespace Sulu\Bundle\FormBundle;

use Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass\DynamicListBuilderCompilerPass;
use Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass\ListProviderCompilerPass;
use Sulu\Component\Symfony\CompilerPass\TaggedServiceCollectorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SuluFormBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ListProviderCompilerPass());
        $container->addCompilerPass(new DynamicListBuilderCompilerPass());
        $container->addCompilerPass(new TaggedServiceCollectorCompilerPass(
            'sulu_form.dynamic.form_field_type_pool',
            'sulu_form.dynamic.type',
            0,
            'alias'
        ));
    }
}

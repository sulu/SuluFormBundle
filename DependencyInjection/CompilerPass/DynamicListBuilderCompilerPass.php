<?php

namespace Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Add all available dynamic list builders to the factory.
 */
class DynamicListBuilderCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sulu_form.list_builder.dynamic_list_factory')) {
            return;
        }

        $definition = $container->getDefinition('sulu_form.list_builder.dynamic_list_factory');
        $taggedServices = $container->findTaggedServiceIds('sulu_form.dynamic_list_builder');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'add',
                    [new Reference($id), $attributes['alias']]
                );
            }
        }
    }
}

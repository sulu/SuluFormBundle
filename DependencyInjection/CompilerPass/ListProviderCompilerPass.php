<?php

namespace Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ListProviderCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sulu.list.provider.registry')) {
            return;
        }

        $definition = $container->getDefinition('sulu.list.provider.registry');
        $taggedServices = $container->findTaggedServiceIds('sulu_form.list_provider');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall(
                    'add',
                    [new Reference($id), $attributes['template']]
                );
            }
        }
    }
}

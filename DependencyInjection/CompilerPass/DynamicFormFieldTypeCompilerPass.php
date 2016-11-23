<?php

namespace Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiler pass for collecting for collecting services tagged with sulu_form.dynamic.type.
 */
class DynamicFormFieldTypeCompilerPass implements CompilerPassInterface
{
    const POOL_SERVICE_ID = 'sulu_form.dynamic.form_field_type_pool';
    const TAG = 'sulu_form.dynamic.type';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::POOL_SERVICE_ID)) {
            return;
        }

        $definition = $container->getDefinition(self::POOL_SERVICE_ID);
        $taggedServices = $container->findTaggedServiceIds(self::TAG);
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

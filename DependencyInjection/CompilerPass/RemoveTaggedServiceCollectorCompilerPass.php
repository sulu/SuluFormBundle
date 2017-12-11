<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveTaggedServiceCollectorCompilerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $tagName;

    /**
     * @var string
     */
    private $aliasAttribute;

    /**
     * @var string
     */
    private $disableParam;

    /**
     * @param string $serviceId
     * @param string $tagName
     * @param int $argumentNumber
     * @param string $aliasAttribute
     */
    public function __construct($tagName, $aliasAttribute, $disableParam)
    {
        $this->tagName = $tagName;
        $this->aliasAttribute = $aliasAttribute;
        $this->disableParam = $disableParam;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $disabledSerivcesAliases = $container->getParameter($this->disableParam);
        $taggedServices = $container->findTaggedServiceIds($this->tagName);

        foreach ($taggedServices as $id => $attributes) {
            if (isset($attributes[0][$this->aliasAttribute])
                    && in_array($attributes[0][$this->aliasAttribute], $disabledSerivcesAliases)) {
                if ($container->hasDefinition($id)) {
                    $container->removeDefinition($id);
                }
            }
        }
    }
}

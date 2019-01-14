<?php

/*
 * This file is part of the Effiana\JsonFormBundle package.
 *
 * (c) Limenius <https://github.com/Limenius/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Effiana\JsonFormBundle\DependencyInjection\Compiler;

use EffianaJsonForm\Transformer\ExtensionInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Nacho Martín <nacho@limenius.com>
 */
class ExtensionCompilerPass implements CompilerPassInterface
{
    const EXTENSION_TAG = 'jsonform.extension';

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('EffianaJsonForm\JsonForm')) {
            return;
        }

        $jsonform = $container->getDefinition('EffianaJsonForm\JsonForm');

        foreach ($container->findTaggedServiceIds(self::EXTENSION_TAG) as $id => $attributes) {
            $extension = $container->getDefinition($id);

            if (!isset(class_implements($extension->getClass())[ExtensionInterface::class])) {
                throw new \InvalidArgumentException(sprintf(
                    "The service %s was tagged as a '%s' but does not implement the mandatory %s",
                    $id,
                    self::EXTENSION_TAG,
                    ExtensionInterface::class
                ));
            }

            $jsonform->addMethodCall('addExtension', [$extension]);
        }
    }
}

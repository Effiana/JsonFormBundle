<?php

/*
 * This file is part of the Effiana\JsonFormBundle package.
 *
 * (c) Limenius <https://github.com/Limenius/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Effiana\JsonFormBundle;

use Effiana\JsonFormBundle\DependencyInjection\Compiler\ExtensionCompilerPass;
use Effiana\JsonFormBundle\DependencyInjection\Compiler\TransformerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Nacho Martín <nacho@limenius.com>
 */
class EffianaJsonFormBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TransformerCompilerPass());
        $container->addCompilerPass(new ExtensionCompilerPass());
    }
}

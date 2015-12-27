<?php

namespace Tystr\ReactJsBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\DependencyInjection\TystrReactJsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TystrReactJsExtensionTest extends PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $config = [
            'tystr_react_js_bundle' => [
                'react_path' => '/path/to/react',
                'components_path' => '/path/to/components',
            ],
        ];

        $extension = new TystrReactJsExtension();
        $container = new ContainerBuilder();

        $extension->load($config, $container);

        $this->assertTrue($container->hasParameter('react_path'));
        $this->assertEquals('/path/to/react', $container->getParameter('react_path'));

        $this->assertTrue($container->hasParameter('components_path'));
        $this->assertEquals('/path/to/components', $container->getParameter('components_path'));
    }
}

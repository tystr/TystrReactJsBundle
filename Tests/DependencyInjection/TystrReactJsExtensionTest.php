<?php

namespace Tystr\ReactJsBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\DependencyInjection\TystrReactJsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TystrReactJsExtensionTest extends PHPUnit_Framework_TestCase
{
    public function testLoadWithDefaults()
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

        $this->assertTrue($container->hasParameter('tystr_react_js.react_path'));
        $this->assertEquals('/path/to/react', $container->getParameter('tystr_react_js.react_path'));

        $this->assertTrue($container->hasParameter('tystr_react_js.components_path'));
        $this->assertEquals('/path/to/components', $container->getParameter('tystr_react_js.components_path'));

        $this->assertTrue($container->hasParameter('tystr_react_js.render_method'));
        $this->assertEquals('v8js', $container->getParameter('tystr_react_js.render_method'));

        $this->assertTrue($container->hasDefinition('tystr_react_js.renderer'));
        $this->assertEquals(
            $container->getDefinition('tystr_react_js.renderer.v8js_adapter')->getClass(),
            $container->getDefinition('tystr_react_js.renderer')->getArgument(0)->getClass()
        );
    }

    public function testLoadWithExternalRenderMethod()
    {
        $config = [
            'tystr_react_js_bundle' => [
                'react_path' => '/path/to/react',
                'components_path' => '/path/to/components',
                'render_method' => 'external',
                'render_url' => 'http://localhost:3000',
            ],
        ];

        $extension = new TystrReactJsExtension();
        $container = new ContainerBuilder();

        $extension->load($config, $container);

        $this->assertTrue($container->hasDefinition('tystr_react_js.renderer.external_adapter'));
        $this->assertEquals(
            'GuzzleHttp\Client',
            $container->getDefinition('tystr_react_js.renderer.external_adapter')->getArgument(0)->getClass()
        );

        $this->assertTrue($container->hasDefinition('tystr_react_js.renderer'));
        $this->assertEquals(
            $container->getDefinition('tystr_react_js.renderer.external_adapter')->getClass(),
            $container->getDefinition('tystr_react_js.renderer')->getArgument(0)->getClass()
        );
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The value "asdf" is not allowed for path "tystr_react_js.render_method". Permissible values: "v8js", "external"
     */
    public function testLoadWithInvalidRenderMethod()
    {
        $config = [
            'tystr_react_js_bundle' => [
                'react_path' => '/path/to/react',
                'components_path' => '/path/to/components',
                'render_method' => 'asdf'
            ],
        ];

        $extension = new TystrReactJsExtension();
        $container = new ContainerBuilder();

        $extension->load($config, $container);
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage You must set the "render_url" key if "render_method" is "external".
     */
    public function testLoadWithMissingRenderUrl()
    {
        $config = [
            'tystr_react_js_bundle' => [
                'react_path' => '/path/to/react',
                'components_path' => '/path/to/components',
                'render_method' => 'external',
            ],
        ];

        $extension = new TystrReactJsExtension();
        $container = new ContainerBuilder();

        $extension->load($config, $container);
    }
}

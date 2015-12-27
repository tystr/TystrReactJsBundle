<?php

namespace Tystr\ReactJsBundle\Tests\Renderer;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\Renderer\ReactJsFactory;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactJsFactoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!extension_loaded('v8js')) {
            $this->markTestSkipped('Install the v8js extension (https://github.com/phpv8/v8js) to run this test.');
        }
    }

    public function testCreateJs()
    {
        $reactPath = __DIR__.'/react.min.js';
        $componentsPath = __DIR__.'/components.js';

        $factory = new ReactJsFactory($reactPath, $componentsPath);
        $reactJS = $factory->createReactJs();
        $this->assertInstanceOf('ReactJS', $reactJS);
    }

    /**
     * @expectedException Tystr\ReactJsBundle\Exception\FileNotReadableException
     * @expectedExceptionMessage React path "/Users/tylerstroud/PhpstormProjects/reactjs-bundle/sandbox/src/Tystr/ReactJsBundle/Tests/Renderer/invalid_react_path" is not readable.
     *
     */
    public function testCreateJsThrowsExceptionWhenReactPathIsNotReadable()
    {
        $reactPath = __DIR__.'/invalid_react_path';
        $componentsPath = __DIR__.'/components.js';

        $factory = new ReactJsFactory($reactPath, $componentsPath);
        $reactJS = $factory->createReactJs();
        $this->assertInstanceOf('ReactJS', $reactJS);
    }

    /**
     * @expectedException Tystr\ReactJsBundle\Exception\FileNotReadableException
     * @expectedExceptionMessage Components path "/Users/tylerstroud/PhpstormProjects/reactjs-bundle/sandbox/src/Tystr/ReactJsBundle/Tests/Renderer/invalid_component_path" is not readable.
     */
    public function testCreateJsThrowsExceptionWhenComponentsPathIsNotReadable()
    {
        $reactPath = __DIR__.'/react.min.js';
        $componentsPath = __DIR__.'/invalid_component_path';

        $factory = new ReactJsFactory($reactPath, $componentsPath);
        $reactJS = $factory->createReactJs();
        $this->assertInstanceOf('ReactJS', $reactJS);
    }
}
<?php

namespace Tystr\ReactJsBundle\Tests;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\ReactJsFactory;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactJsFactoryTest extends PHPUnit_Framework_TestCase
{
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
     * @expectedExceptionMessage React path "/Users/tylerstroud/PhpstormProjects/reactjs-bundle/sandbox/src/Tystr/ReactJsBundle/Tests/invalid_react_path" is not readable.
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
     * @expectedExceptionMessage Components path "/Users/tylerstroud/PhpstormProjects/reactjs-bundle/sandbox/src/Tystr/ReactJsBundle/Tests/invalid_component_path" is not readable.
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
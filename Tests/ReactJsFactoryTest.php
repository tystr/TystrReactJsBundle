<?php

namespace Tystr\ReactJsBundle\Tests;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\ReactJsFactory;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactJsFactoryTest extends PHPUnit_Framework_TestCase
{
    protected $factory;
    public function setUp()
    {
        $reactPath = __DIR__.'/react.min.js';
        $componentsPath = __DIR__.'/components.js';
        $this->factory = new ReactJsFactory($reactPath, $componentsPath);
    }

    public function testCreateJs()
    {
        $reactJS = $this->factory->createReactJs();
        $this->assertInstanceOf('ReactJs', $reactJS);
    }
}
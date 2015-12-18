<?php

namespace Tystr\ReactJsBundle\Tests\Twig;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\Twig\ReactJsExtension;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactJsExtensionTest extends PHPUnit_Framework_TestCase
{
    private $react;
    private $extension;

    public function setUp()
    {
        $this->react = $this->getMockBuilder('ReactJS')->disableOriginalConstructor()->getMock();
        $this->extension = new ReactJsExtension($this->react);
    }

    public function testGetFunctions()
    {
        $functions = $this->extension->getFunctions();

        $this->assertArrayHasKey('react_component', $functions);
        $this->assertArrayHasKey('react_mount_components', $functions);

    }

    public function testReactComponent()
    {
        $this->react->expects($this->once())
            ->method('setComponent')
            ->with('MyComponent', null);

        $this->react->expects($this->once())
            ->method('getJS');

        $this->react->expects($this->once())
            ->method('getMarkup')
            ->will($this->returnValue('MARKUP'));

        $renderedComponent = $this->extension->renderReactComponent('MyComponent', 'my-component');

        $this->assertEquals('<div id="my-component">MARKUP</div>', $renderedComponent);
    }

    public function testRenderReactComponentJs()
    {
        $this->react->expects($this->exactly(2))
            ->method('setComponent');

        $this->react->expects($this->exactly(2))
            ->method('getJS')
            ->will($this->onConsecutiveCalls('js1;', 'js2;'));

        $this->react->expects($this->exactly(2))
            ->method('getMarkup');

        $this->extension->renderReactComponent('MyComponent1', 'my-component1');
        $this->extension->renderReactComponent('MyComponent2', 'my-component2');

        $js = $this->extension->renderReactComponentsJs();
        $this->assertEquals("js1;\njs2;", $js);
    }
}

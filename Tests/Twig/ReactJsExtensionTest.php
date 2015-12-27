<?php

namespace Tystr\ReactJsBundle\Tests\Twig;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\Twig\ReactJsExtension;
use Twig_Node;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactJsExtensionTest extends PHPUnit_Framework_TestCase
{
    private $renderer;
    private $extension;

    public function setUp()
    {
        $this->renderer = $this->getMockBuilder('Tystr\ReactJsBundle\Renderer\ReactRenderer')
            ->disableOriginalConstructor()
            ->getMock();
        $this->extension = new ReactJsExtension($this->renderer);
    }

    public function testGetName()
    {
        $this->assertEquals('reactjs', $this->extension->getName());
    }

    public function testGetFunctions()
    {
        $functions = $this->extension->getFunctions();

        $this->assertArrayHasKey('react_component', $functions);
        $this->assertArrayHasKey('react_mount_components', $functions);
        $this->assertArrayHasKey('react_mount_component', $functions);

        $reactComponent = $functions['react_component'];
        $this->assertEquals('react_component', $reactComponent->getName());
        $this->assertEquals([$this->extension, 'renderReactComponent'], $reactComponent->getCallable());
        $this->assertEquals(['html'], $reactComponent->getSafe(new Twig_Node()));

        $reactMountComponents = $functions['react_mount_components'];
        $this->assertEquals('react_mount_components', $reactMountComponents->getName());
        $this->assertEquals([$this->extension, 'renderReactComponentsJs'], $reactMountComponents->getCallable());
        $this->assertEquals(['html'], $reactMountComponents->getSafe(new Twig_Node()));

        $reactMountComponent = $functions['react_mount_component'];
        $this->assertEquals('react_mount_component', $reactMountComponent->getName());
        $this->assertEquals([$this->extension, 'renderReactComponentJs'], $reactMountComponent->getCallable());
        $this->assertEquals(['html'], $reactMountComponent->getSafe(new Twig_Node()));
    }

    public function testReactComponent()
    {
        $this->renderer->expects($this->once())
            ->method('render')
            ->with('MyComponent')
            ->willReturn('MARKUP');

        $renderedComponent = $this->extension->renderReactComponent('MyComponent', 'my-component');

        $this->assertEquals('<div id="my-component">MARKUP</div>', $renderedComponent);
    }

    public function testRenderReactComponentJs()
    {
        $this->renderer->expects($this->exactly(2))
            ->method('render');

        $this->renderer->expects($this->exactly(2))
            ->method('getRenderJs')
            ->will($this->onConsecutiveCalls('js1;', 'js2;'));

        $this->extension->renderReactComponent('MyComponent1', 'my-component1');
        $this->extension->renderReactComponent('MyComponent2', 'my-component2');

        $js = $this->extension->renderReactComponentsJs();
        $this->assertEquals("js1;\njs2;", $js);
    }

    public function testRenderSingleReactComponentJs()
    {
        $this->renderer->expects($this->exactly(2))
            ->method('render');

        $this->renderer->expects($this->exactly(2))
            ->method('getRenderJs')
            ->will($this->onConsecutiveCalls('js1;', 'js2;'));

        $this->extension->renderReactComponent('MyComponent1', 'my-component1');
        $this->extension->renderReactComponent('MyComponent2', 'my-component2');

        $js = $this->extension->renderReactComponentJs('MyComponent2');
        $this->assertEquals("js2;", $js);
    }

    /**
     * @expectedException Tystr\ReactJsBundle\Exception\ComponentNotRenderedException
     */
    public function testRenderSingleReactComponentJsThrowsException()
    {
        $this->extension->renderReactComponentJs('MyComponent');
    }
}

<?php

namespace Tystr\ReactJsBundle\Tests\Renderer;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\Renderer\ReactJsFactory;
use Tystr\ReactJsBundle\Renderer\ReactRenderer;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactRendererTest extends PHPUnit_Framework_TestCase
{
    private $renderer;

    public function setUp()
    {
        $this->adapter = $this->getMockBuilder('Tystr\ReactJsBundle\Renderer\AdapterInterface')->getMockForAbstractClass();
        $this->renderer = new ReactRenderer($this->adapter);

    }

    public function testRender()
    {
        $this->adapter->expects($this->once())
            ->method('render')
            ->with('MyComponent')
            ->willReturn('<h1>hello world</h1>');
        $this->assertEquals('<h1>hello world</h1>', $this->renderer->render('MyComponent'));
    }

    public function testRenderWithData()
    {
        $this->adapter->expects($this->once())
            ->method('render')
            ->with('MyComponent', ['name' => 'Tyler'])
            ->willReturn('<h1>hello world</h1>');
        $this->assertEquals('<h1>hello world</h1>', $this->renderer->render('MyComponent', ['name' => 'Tyler']));
    }

    public function testGetRenderJs()
    {
        $this->assertEquals(
            'React.render(React.createElement(MyComponent, []), my-div);',
            $this->renderer->getRenderJs('MyComponent', 'my-div')
        );
    }

    public function testGetRenderJsWithData()
    {
        $this->assertEquals(
            'React.render(React.createElement(MyComponent, {"name":"Tyler"}), my-div);',
            $this->renderer->getRenderJs('MyComponent', 'my-div', ['name' => 'Tyler'])
        );
    }
}

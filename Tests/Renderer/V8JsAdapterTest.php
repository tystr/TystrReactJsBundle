<?php

namespace Tystr\ReactJsBundle\Tests\Renderer;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\Renderer\V8jsAdapter;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class V8jsAdapterTest extends PHPUnit_Framework_TestCase
{
    private $react;
    private $adapter;

    public function setUp()
    {
        $this->react= $this->getMockBuilder('ReactJS')->disableOriginalConstructor()->getMock();
        $this->adapter = new V8jsAdapter($this->react);
    }

    public function testRender()
    {
        $this->react->expects($this->once())
            ->method('setComponent')
            ->with('MyComponent')
            ->willReturn($this->react);

        $this->react->expects($this->once())
            ->method('getMarkup')
            ->willReturn('<h1>hello world</h1>');

        $this->assertEquals('<h1>hello world</h1>', $this->adapter->render('MyComponent'));
    }

    public function testRenderWithData()
    {
        $this->react->expects($this->once())
            ->method('setComponent')
            ->with('MyComponent', ['name' => 'Tyler'])
            ->willReturn($this->react);

        $this->react->expects($this->once())
            ->method('getMarkup')
            ->willReturn('<h1>hello world</h1>');

        $this->assertEquals('<h1>hello world</h1>', $this->adapter->render('MyComponent', ['name' => 'Tyler']));
    }
}

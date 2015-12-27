<?php

namespace Tystr\ReactJsBundle\Tests\Renderer;

use PHPUnit_Framework_TestCase;
use Tystr\ReactJsBundle\Renderer\ExternalAdapter;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ExternalAdapterTest extends PHPUnit_Framework_TestCase
{
    private $client;
    private $adapter;

    public function setUp()
    {
        $this->client = $this->getMockBuilder('GuzzleHttp\ClientInterface')->getMockForAbstractClass();
        $this->adapter = new ExternalAdapter($this->client);
    }

    public function testRender()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', '?component=MyComponent&data=%5B%5D')
            ->willReturn('<h1>Hello Tyler</h1>');

        $this->assertEquals('<h1>Hello Tyler</h1>', $this->adapter->render('MyComponent'));
    }

    public function testRenderWithData()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', '?component=MyComponent&data=%7B%22name%22%3A%22Tyler%22%7D')
            ->willReturn('<h1>Hello Tyler</h1>');

        $this->assertEquals('<h1>Hello Tyler</h1>', $this->adapter->render('MyComponent', ['name' => 'Tyler']));
    }
}

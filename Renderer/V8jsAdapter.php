<?php

namespace Tystr\ReactJsBundle\Renderer;

use ReactJS;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class V8jsAdapter implements AdapterInterface
{
    /**
     * @var ReactJS
     */
    private $react;

    /**
     * @param ReactJS $react
     */
    public function __construct(ReactJS $react)
    {
        $this->react = $react;
    }

    /**
     * @param string $component Name of component
     * @param array  $data      Data to pass to the component
     *
     * @return string
     */
    public function render($component, array $data = [])
    {
        return $this->react->setComponent($component, $data)->getMarkup();
    }
}

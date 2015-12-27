<?php

namespace Tystr\ReactJsBundle\Renderer;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
interface AdapterInterface
{
    /**
     * @param string $component Name of the component
     * @param array  $data      Data to pass to the component
     *
     * @return string
     */
    public function render($component, array $data = []);
}

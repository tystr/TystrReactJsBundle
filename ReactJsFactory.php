<?php

namespace Tystr\ReactJsBundle;

use ReactJS;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactJsFactory
{
    /**
     * @var string
     */
    private $reactPath;

    /**
     * @var string
     */
    private $componentsPath;

    /**
     * @param string $reactPath
     * @param string $componentsPath
     */
    public function __construct($reactPath, $componentsPath)
    {
        $this->reactPath = $reactPath;
        $this->componentsPath = $componentsPath;
    }

    /**
     * @return ReactJS
     */
    public function createReactJs()
    {
        $react = file_get_contents($this->reactPath);
        $js = file_get_contents($this->componentsPath);

        return new ReactJS($react, $js);
    }
}

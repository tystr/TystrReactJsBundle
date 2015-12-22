<?php

namespace Tystr\ReactJsBundle;

use ReactJS;
use Tystr\ReactJsBundle\Exception\FileNotReadableException;

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
        if (!is_readable($this->reactPath)) {
            throw new FileNotReadableException(sprintf('React path "%s" is not readable.', $this->reactPath));
        }

        if (!is_readable($this->componentsPath)) {
            throw new FileNotReadableException(sprintf('Components path "%s" is not readable.', $this->componentsPath));
        }

        $react = file_get_contents($this->reactPath);
        $js = file_get_contents($this->componentsPath);

        return new ReactJS($react, $js);
    }
}

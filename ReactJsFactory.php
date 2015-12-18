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
    private $reactJsSource;

    /**
     * @var string
     */
    private $javascriptsSource;

    /**
     * @param string $reactJsSource
     * @param string $javascriptsSource
     */
    public function __construct($reactJsSource, $javascriptsSource)
    {
        $this->reactJsSource = $reactJsSource;
        $this->javascriptsSource = $javascriptsSource;
    }

    /**
     * @return ReactJS
     */
    public function createReactJs()
    {
        $react = file_get_contents($this->reactJsSource);
        $js = file_get_contents($this->javascriptsSource);

        return new ReactJS($react, $js);
    }
}

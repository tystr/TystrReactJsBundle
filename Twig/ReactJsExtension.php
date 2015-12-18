<?php

namespace Tystr\ReactJsBundle\Twig;

use Twig_Extension;
use ReactJS;
use Twig_SimpleFunction;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactJsExtension extends Twig_Extension
{
    /**
     * @var ReactJS
     */
    private $reactJS;

    /**
     * @var string
     */
    private $tag = 'div';

    /**
     * @var array
     */
    private $componentsJs = [];

    /**
     * @param ReactJS $reactJS
     */
    public function __construct(ReactJS $reactJS, $wrapperTag = 'div')
    {
        $this->reactJS = $reactJS;
        $this->tag = $wrapperTag;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'react_component' => new Twig_SimpleFunction(
                'react_component',
                [$this, 'renderReactComponent'],
                ['is_safe' => ['html']]
            ),
            'react_mount_components' => new Twig_SimpleFunction(
                'react_mount_components',
                [$this, 'renderReactComponentsJs'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'reactjs';
    }

    /**
     * @param string $componentName
     * @param string $containerId
     * @param mixed  $data
     *
     * @return string
     */
    public function renderReactComponent($componentName, $containerId, $data = null)
    {
        $this->reactJS->setComponent($componentName, $data);
        $this->componentsJs[] = $this->reactJS->getJS('document.getElementById(\''.$containerId.'\')');

        return sprintf($this->getWrapper(), $containerId, $this->reactJS->getMarkup());
    }

    /**
     * @return string
     */
    public function renderReactComponentsJs()
    {
        return implode("\n", $this->componentsJs);
    }

    /**
     * @return string
     */
    protected function getWrapper()
    {
        return "<$this->tag id=\"%s\">%s</$this->tag>";
    }
}


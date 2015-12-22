<?php

namespace Tystr\ReactJsBundle\Twig;

use Twig_Extension;
use ReactJS;
use Twig_SimpleFunction;
use Tystr\ReactJsBundle\Exception\ComponentNotRenderedException;

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
            'react_mount_component' => new Twig_SimpleFunction(
                'react_mount_component',
                [$this, 'renderReactComponentJs'],
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
     * Render a react component's markup and store it's js for mounting later
     *
     * @param string $componentName
     * @param string $containerId
     * @param mixed  $data
     *
     * @return string
     */
    public function renderReactComponent($componentName, $containerId, $data = null)
    {
        $this->reactJS->setComponent($componentName, $data);
        $this->componentsJs[$componentName] = $this->reactJS->getJS('document.getElementById(\''.$containerId.'\')');

        return sprintf($this->getWrapper(), $containerId, $this->reactJS->getMarkup());
    }

    /**
     * Mount all components
     *
     * @return string
     */
    public function renderReactComponentsJs()
    {
        return implode("\n", $this->componentsJs);
    }

    /**
     * Mount a single react component
     *
     * @param string $componentName
     */
    public function renderReactComponentJs($componentName)
    {
        if (!isset($this->componentsJs[$componentName])) {
            throw new ComponentNotRenderedException(
                'You must render a component before it can be mounted.'
            );
        }

        return $this->componentsJs[$componentName];
    }

    /**
     * @return string
     */
    protected function getWrapper()
    {
        return "<$this->tag id=\"%s\">%s</$this->tag>";
    }
}


<?php

namespace Tystr\ReactJsBundle\Renderer;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ReactRenderer
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $component Name of the component to render
     * @param array  $data      Data to pass to the component
     *
     * @return string
     */
    public function render($component, array $data = [])
    {
        return $this->adapter->render($component, $data);
    }

    /**
     * @param string $component Name of component
     * @param string $where     Id of container in which component is rendered
     * @param array  $data      Data to be passed to the component
     *
     * @return string
     */
    public function getRenderJs($component, $where, array $data = [])
    {
        return
            sprintf(
                'React.render(React.createElement(%s, %s), %s);',
                $component,
                json_encode($data),
                $where
            );
    }
}
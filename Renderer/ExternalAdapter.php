<?php

namespace Tystr\ReactJsBundle\Renderer;

use GuzzleHttp\ClientInterface;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class ExternalAdapter implements AdapterInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $component Name of component to render
     * @param array  $data      Data to be passed to the component
     *
     * @return string
     */
    public function render($component, array $data = [])
    {
        $query = sprintf(
            '?component=%s&data=%s',
            urlencode($component),
            urlencode(json_encode($data)));

        // @todo exception handling
        return $this->client->request('GET', $query);
    }
}

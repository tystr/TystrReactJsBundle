<?php

namespace Tystr\ReactJsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Tyler Stroud <tyler@tylerstroud.com>
 */
class TystrReactJsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('tystr_react_js.react_path', $config['react_path']);
        $container->setParameter('tystr_react_js.components_path', $config['components_path']);
        $container->setParameter('tystr_react_js.render_method', $config['render_method']);
        $container->setParameter('tystr_react_js.render_url', isset($config['render_url']) ? $config['render_url'] : null);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $rendererDefinition = $container->getDefinition('tystr_react_js.renderer');
        if ('external' === $config['render_method']) {
            if (!isset($config['render_url'])) {
                throw new InvalidConfigurationException(
                    'You must set the "render_url" key if "render_method" is "external".'
                );
            }

            $clientDefinition = new Definition('GuzzleHttp\Client', [['base_uri' => $config['render_url']]]);
            $container->setDefinition('tystr_react_js.client', $clientDefinition);
            $container->getDefinition('tystr_react_js.renderer.external_adapter')
                ->replaceArgument(0, $clientDefinition);
            $rendererDefinition
                ->replaceArgument(0, $container->getDefinition('tystr_react_js.renderer.external_adapter'));
        } else {
            $rendererDefinition->replaceArgument(0, $container->getDefinition('tystr_react_js.renderer.v8js_adapter'));
        }
    }
}

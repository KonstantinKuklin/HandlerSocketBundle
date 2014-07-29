<?php

namespace KonstantinKuklin\HandlerSocketBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HSExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('hs.reader.host', $config['reader']['host']);
        $container->setParameter('hs.reader.port', $config['reader']['port']);
        $container->setParameter('hs.reader.auth_key', $config['reader']['auth_key']);

        $container->setParameter('hs.writer.host', $config['writer']['host']);
        $container->setParameter('hs.writer.port', $config['writer']['port']);
        $container->setParameter('hs.writer.auth_key', $config['writer']['auth_key']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'hs';
    }
}

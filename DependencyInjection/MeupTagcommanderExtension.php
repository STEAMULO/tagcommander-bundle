<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MeupTagcommanderExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(
            new Configuration(),
            $configs
        );

        $this
            ->loadDataLayer    ($config, $container)
            ->loadTwigExtension($config, $container)
            ->loadCollector    ($config, $container)
            ->TemplatingRender ($config, $container)
        ;
    }

    /**
     *
     */
    public function TemplatingRender(array $config, ContainerBuilder $container)
    {
        $container->setParameter('debug.templating.engine.twig.class', 'Meup\Bundle\TagcommanderBundle\Templating\TimedEngine');
        $container->setParameter('templating.engine.twig.class', 'Meup\Bundle\TagcommanderBundle\Templating\Engine');
    }

    /**
     * Setting up datalayer
     *
     * @param Array $config
     * @param ContainerBuilder $container
     * 
     * @return self
     */
    protected function loadDataLayer(array $config, ContainerBuilder $container)
    {
        $datalayer = new Definition(
            'Symfony\Component\DependencyInjection\ParameterBag\ParameterBag',
            array(
                $config['datalayer']['default']
            )
        );
        $datalayer->setPublic(false);
        $container->setDefinition(
            'meup_tagcommander.datalayer',
            $datalayer
        );
        $container->setAlias('tc_datalayer', 'meup_tagcommander.datalayer');

        return $this;
    }

    /**
     * @param Array $config
     * @param ContainerBuilder $container
     * 
     * @return self
     */
    protected function loadTwigExtension(array $config, ContainerBuilder $container)
    {
        $twig_extension = new Definition(
            'Meup\Bundle\TagcommanderBundle\Twig\TagcommanderExtension',
            array(
                new Reference('meup_tagcommander.datalayer'),
                new Reference('event_dispatcher'),
                $config['datalayer']['name']
            )
        );
        $twig_extension->addTag('twig.extension');
        $twig_extension->setPublic(false);

        foreach ($config['containers'] as $tc_container) {
            $twig_extension->addMethodCall('addContainer', array($tc_container));
        }
        foreach ($config['events'] as $tc_event) {
            $twig_extension->addMethodCall('addEvent', array($tc_event, $tc_event['name']==$config['default_event']));
        }

        $container->setDefinition(
            'meup_tagcommander.twig_extension',
            $twig_extension
        );

        return $this;
    }

    /**
     * Setting up the datalayer collector for the toolbar
     *
     * @param Array $config
     * @param ContainerBuilder $container
     * 
     * @return self
     */
    protected function loadCollector(array $config, ContainerBuilder $container)
    {
        $datacollector = new Definition(
            'Meup\Bundle\TagcommanderBundle\DataCollector\DataLayerCollector',
            array(
                new Reference('meup_tagcommander.datalayer')
            )
        );
        $datacollector
            ->addTag('data_collector',
                array(
                    'template' => 'MeupTagcommanderBundle:Collector:datalayer.html.twig',
                    'id'       => 'datalayer',
                )
            )
        ;
        $datacollector->setPublic(false);
        $container->setDefinition(
            'meup_tagcommander.datacollector',
            $datacollector
        );

        $subscriber = new Definition(
            'Meup\Bundle\TagcommanderBundle\EventDispatcher\Subscriber\CollectorSubscriber',
            array(
                new Reference('meup_tagcommander.datacollector'),
            )
        );
        $subscriber->setPublic(false);
        $container->setDefinition('meup_tagcommander.datacollector_subscriber', $subscriber);

        return $this;
    }
}

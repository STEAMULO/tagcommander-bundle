<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagCommanderBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MeupTagCommanderExtension extends Extension
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



        $container->setDefinition(
            'meup_tagcommander.datalayer',
            new Definition('Symfony\Component\DependencyInjection\ParameterBag\ParameterBag')
        );


        $datacollector = new Definition(
            'Meup\Bundle\TagCommanderBundle\DataCollector\DataLayerCollector',
            new Reference('meup_tagcommander.datalayer')
        );
        $datacollector
            ->addTag('data_collector',
                array(
                    'template' => 'MeupTagCommanderBundle:Collector:datalayer.html.twig',
                    'id' => 'datalayer',
                )
            )
        ;
        $container->setDefinition(
            'meup_tagcommander.datacollector',
            $datacollector
        );


        /*
        $twig_extension = new Definition(
            'Meup\Bundle\TagCommanderBundle\Twig\TagCommanderExtension',
            array(
                new Reference('meup_tagcommander.datalayer')
            )
        );
        $twig_extension->addTag('twig.extension');
        
        $container->setDefinition('meup_tagcommander.twig_extension', $twig_extension);
        */
    }
}

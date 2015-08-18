<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 *
 */
class TagcommanderExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $datalayer  = new ParameterBag();
        $dispatcher = new EventDispatcher();
        $tc_vars    = 'toto_var';
        $extension  = new TagcommanderExtension($datalayer, $dispatcher, $tc_vars);


        $tc_container_config = array(
            'name'   => 'ab-test',
            'script' => 'my-ab-test-container.js',
        );
        $extension->addContainer($tc_container_config);

        $tc_event_config = array(
            'name'     => 'generic',
            'function' => 'tc_event_1',
        );
        $extension->addEvent($tc_event_config);

        $this->assertEquals('tagcommander_extension', $extension->getName());


        $doc = new \DOMDocument();
        $doc->loadHTML(
            $extension->tcVars(array('lorem'=>'ipsum'))
        );
        $str = trim($doc->getElementsByTagName('script')->item(0)->nodeValue, ' ;');

        list($name, $values) = sscanf($str, 'var %s = %s');

        $serializer = new Serializer(
            array(new ObjectNormalizer()),
            array(new JsonEncoder())
        );
        $values = json_decode($values);

        $this->assertEquals('ipsum', $values->lorem);
    }
}
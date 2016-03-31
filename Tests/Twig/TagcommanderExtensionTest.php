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
        $datalayer  = new ParameterBag(array('foo' => 'bar'));
        $dispatcher = new EventDispatcher();

        $tc_vars    = 'toto_var';
        $extension  = new TagcommanderExtension($datalayer, $dispatcher, $tc_vars);
        $this->assertEquals('tagcommander_extension', $extension->getName());


        $tc_container_config = array(
            'name'        => 'ab-test',
            'script'      => 'my-ab-test-container.js',
            'version'     => 1,
            'alternative' => 'none',
        );
        $extension->addContainer($tc_container_config);

        $tc_event_config = array(
            'name'     => 'generic',
            'function' => 'tc_event_1',
        );
        $extension->addEvent($tc_event_config);

        $this->assertEquals('tagcommander_extension', $extension->getName());



        $functions = array_reduce(
            $extension->getFunctions(),
            function($functions, $twig_function) {
                $functions[] = $twig_function->getName();
                return $functions;
            }
        );
        $this->assertTrue(in_array('tc_vars', $functions));
        $this->assertTrue(in_array('tc_container', $functions));
        $this->assertTrue(in_array('tc_event', $functions));



        /* test tc_vars */
        $doc = new \DOMDocument();
        $doc->loadHTML(
            $extension->tcVars(array('lorem'=>'ipsum'))
        );
        $str = trim($doc->getElementsByTagName('script')->item(0)->nodeValue, ' ;');
        list(, $values) = sscanf($str, 'var %s = %s');
        $values = json_decode($values);

        $this->assertEquals('ipsum', $values->lorem);


        $container  = '<script type="text/javascript" src="my-ab-test-container.js?1"></script>';
        $container .= '<noscript><iframe src="none" width="1" height="1" rel="noindex,nofollow"></iframe></noscript>';

        /* test tc_event */
        $this->assertEquals("tc_event_1('click', {\"foo\":\"bar\"});", $extension->tcEvent('click'));
        $this->assertEquals($container, $extension->tcContainer('ab-test'));
    }
}

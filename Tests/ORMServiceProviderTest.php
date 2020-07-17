<?php

/*
 * This file is part of the Omed project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Omed\Laravel\ORM\Tests;

use LaravelDoctrine\Extensions\Timestamps\TimestampableExtension;
use Omed\Laravel\ORM\Tests\Fixtures\Model\TestAnnotation;
use Omed\Laravel\ORM\Tests\Fixtures\XML\TestXML;

class ORMServiceProviderTest extends TestCase
{

    public function testConfig()
    {
        $extensions = config('doctrine.extensions');
        $this->assertContains(TimestampableExtension::class, $extensions);
    }

    public function testAnnotationMappings()
    {
        $test = new TestAnnotation();
        $test->setName('foo');
        /* @var \LaravelDoctrine\ORM\IlluminateRegistry $registry */
        $registry = $this->app->get('registry');
        $em = $registry->getManager();
        $em->persist($test);
        $em->flush();
        $this->assertNotNull($test->getId());
    }

    public function testXMLMappings()
    {
        $test = new TestXML();
        $test->setName('foo');
        /* @var \LaravelDoctrine\ORM\IlluminateRegistry $registry */
        $registry = $this->app->get('registry');
        $em = $registry->getManager();
        $em->persist($test);
        $em->flush();
        $this->assertNotNull($test->getId());
    }
}

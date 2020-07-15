<?php

namespace Omed\Laravel\ORM\Tests;


use LaravelDoctrine\Extensions\Timestamps\TimestampableExtension;
use Omed\Laravel\ORM\ORMServiceProvider;
use Omed\Laravel\ORM\Testing\ORMTestCase;

class ORMServiceProviderTest extends ORMTestCase
{
    protected function getPackageProviders($app)
    {
        return [

            ORMServiceProvider::class,
        ];
    }

    public function testConfig()
    {
        $extensions = config('doctrine.extensions');

        $this->assertContains(TimestampableExtension::class, $extensions);
    }
}

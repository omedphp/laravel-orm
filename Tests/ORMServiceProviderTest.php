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

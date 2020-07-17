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

use Omed\Laravel\ORM\Testing\ORMTestCase;

class TestCase extends ORMTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('doctrine:schema:create');
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('doctrine.managers.default.mappings', [
            'Omed\Laravel\ORM\Tests\Fixtures\Model' => [
                'type' => 'annotation',
                'paths' => __DIR__.'/Fixtures/Model',
            ],
            'Omed\Laravel\ORM\Tests\Fixtures\XML' => [
                'type' => 'xml',
                'paths' => __DIR__.'/Fixtures/config/xml',
            ],
        ]);
    }
}

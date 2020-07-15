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

namespace Omed\Laravel\ORM\Testing;

use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class ORMTestCase extends BaseTestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $defPath = storage_path('/temp/model');
        if (!is_dir($defPath)) {
            mkdir($defPath, 0777, true);
        }
        $app['config']->set('doctrine.managers.default.connection', 'sqlite');
        $app['config']->set('doctrine.managers.default.paths', [$defPath]);
    }
}

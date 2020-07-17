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

namespace Omed\Laravel\ORM;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\Extensions\Timestamps\TimestampableExtension;
use LaravelDoctrine\ORM\BootChain;
use Omed\Laravel\ORM\Resolvers\TargetEntityResolver;

class ORMServiceProvider extends ServiceProvider
{
    public function boot(Repository $config)
    {
        $this->configureRepository($config);
    }

    public function register()
    {
        $this->registerTargetEntityResolver();
    }

    public function provides()
    {
        return [
            TargetEntityResolver::class
        ];
    }


    private function registerTargetEntityResolver()
    {
        $this->app->singleton(TargetEntityResolver::class, function(Application $app){
            $config = $app->make('config')->get('doctrine.resolve_target_entities',[]);
            $resolver = new TargetEntityResolver($config);
            BootChain::add([$resolver,'handleOnBoot']);
            return $resolver;
        });
        $this->app->make(TargetEntityResolver::class);
    }

    private function configureRepository(Repository $config)
    {
        $extensions = $config->get('doctrine_extensions');
        $extensions = \is_array($extensions) ? $extensions : [];
        $extensions = array_merge($extensions, [
            TimestampableExtension::class,
        ]);
        $config->set('doctrine.extensions', $extensions);
    }
}

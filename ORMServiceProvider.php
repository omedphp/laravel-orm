<?php


namespace Omed\Laravel\ORM;


use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\Extensions\Timestamps\TimestampableExtension;

class ORMServiceProvider extends ServiceProvider
{
    public function boot(Repository $config)
    {
        $config = $this->app['config'];
        $this->configureRepository($config);
    }

    public function register()
    {

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
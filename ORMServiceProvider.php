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

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\Extensions\Timestamps\TimestampableExtension;
use LaravelDoctrine\ORM\IlluminateRegistry;

class ORMServiceProvider extends ServiceProvider
{
    public function boot(Repository $config)
    {
        $this->configureRepository($config);
    }

    public function register()
    {
    }

    /**
     * @param IlluminateRegistry $registry
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function handleOnDoctrineBoot($registry)
    {
        /** @var EntityManagerInterface $manager */
        $managers = config('doctrine.managers', []);
        foreach ($managers as $name => $settings) {
            $manager = $registry->getManager($name);
            $this->configureEntityManager($name, $manager, $settings);
        }

        return;
    }

    /**
     * @param string                 $managerName
     * @param EntityManagerInterface $om
     * @param array                  $settings
     *
     * @throws \Doctrine\ORM\ORMException on getMedataDriverImpl
     */
    private function configureEntityManager($managerName, EntityManagerInterface $om, array $settings = [])
    {
        if (!isset($settings['mappings']) || empty($settings['mappings'])) {
            return;
        }
        /** @var \LaravelDoctrine\ORM\Extensions\MappingDriverChain $chain */
        $chain = $om->getConfiguration()->getMetadataDriverImpl();
        $mappings = $settings['mappings'];

        $annotationDriver = $chain->getDefaultDriver();
        foreach ($mappings as $namespace => $config) {
            $targetManager = $config['manager'] ?? 'default';
            if ($managerName != $targetManager) {
                continue;
            }
            if (!isset($config['paths'])) {
                throw new \InvalidArgumentException('Doctrine mappings "paths" config should be configured.');
            }

            $type = $config['type'] ?? 'annotation';
            $paths = $config['paths'];
            if ('annotation' == $type) {
                $paths = \is_string($paths) ? [$paths] : $paths;
                $annotationDriver->addPaths($paths);
                $chain->addDriver($annotationDriver, $namespace);
            }
            if ('xml' == $type) {
                $xmlDriver = new SimplifiedXmlDriver([$paths => $namespace]);
                $chain->addDriver($xmlDriver, $namespace);
            }
        }
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

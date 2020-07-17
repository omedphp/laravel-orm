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

namespace Omed\Laravel\ORM\Resolvers;

use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use LaravelDoctrine\ORM\IlluminateRegistry;

class TargetEntityResolver extends ResolveTargetEntityListener
{
    public function __construct(array $config)
    {
        foreach ($config as $abstract => $concrete) {
            $this->addResolveTargetEntity($abstract, $concrete, []);
        }
    }

    /**
     * @param IlluminateRegistry $registry
     */
    public function handleOnBoot($registry)
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $manager */
        foreach ($registry->getManagers() as $manager) {
            $manager->getEventManager()->addEventSubscriber($this);
        }
    }
}

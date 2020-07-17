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

namespace Omed\Laravel\ORM\Tests\Resolvers;

use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use Omed\Laravel\ORM\Resolvers\TargetEntityResolver;
use PHPUnit\Framework\TestCase;

interface TestIlluminateRegistry
{
    public function getManagers();
}

class TargetEntityResolverTest extends TestCase
{
    private $config = [
        'App\\Contracts\\InvoiceSubjectInterface' => 'App\\Model\\Customer',
    ];

    public function testHandleOnBoot()
    {
        $registry = $this->createMock(TestIlluminateRegistry::class);
        $events = $this->createMock(EventManager::class);
        $manager = $this->createMock(EntityManagerInterface::class);
        $resolver = new TargetEntityResolver($this->config);

        $registry->expects($this->once())
            ->method('getManagers')
            ->willReturn([$manager]);
        $manager->expects($this->once())
            ->method('getEventManager')
            ->willReturn($events);
        $events->expects($this->once())
            ->method('addEventSubscriber')
            ->with($resolver);

        $resolver->handleOnBoot($registry);
    }
}

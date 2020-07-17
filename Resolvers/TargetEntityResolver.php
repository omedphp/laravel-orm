<?php


namespace Omed\Laravel\ORM\Resolvers;


use Doctrine\ORM\Tools\ResolveTargetEntityListener;
use LaravelDoctrine\ORM\IlluminateRegistry;

class TargetEntityResolver extends ResolveTargetEntityListener
{
    public function __construct(array $config)
    {
        foreach($config as $abstract => $concrete){
            $this->addResolveTargetEntity($abstract, $concrete,[]);
        }
    }

    /**
     * @param IlluminateRegistry $registry
     */
    public function handleOnBoot($registry)
    {
        /* @var \Doctrine\ORM\EntityManagerInterface $manager */
        foreach($registry->getManagers() as $manager){
            $manager->getEventManager()->addEventSubscriber($this);
        }
    }
}
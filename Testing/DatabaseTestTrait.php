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

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;

trait DatabaseTestTrait
{
    protected function buildSchema()
    {
        /** @var \Doctrine\Persistence\ManagerRegistry $registry */
        $registry = app()->get('registry');
        $em = $registry->getManager($registry->getDefaultManagerName());
        $metadatas = [];
        foreach ($registry->getManagers() as $manager) {
            $metadata = $manager->getMetadataFactory()->getAllMetadata();
            $metadatas = array_merge($metadatas, $metadata);
        }

        $tool = new SchemaTool($em);
        try {
            $tool->dropSchema($metadatas);
            $tool->createSchema($metadatas);
        } catch (ToolsException $e) {
            throw new \InvalidArgumentException(sprintf('Database schema is not buildable: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }

    protected function populateDatabase()
    {
    }
}

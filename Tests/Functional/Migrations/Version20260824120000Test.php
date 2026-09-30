<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Psr\Log\NullLogger;
use Sulu\Bundle\FormBundle\Migrations\Version20260824120000;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class Version20260824120000Test extends SuluTestCase
{
    private Connection $connection;

    protected function setUp(): void
    {
        self::bootKernel();
        self::purgeDatabase();

        $this->connection = self::getEntityManager()->getConnection();
    }

    protected function tearDown(): void
    {
        // Restore the canonical schema so following tests are not affected.
        $this->createMigration()->up($this->introspectSchema());

        parent::tearDown();
    }

    public function testUpRestoresTheAuditForeignKeys(): void
    {
        $this->createMigration()->down($this->introspectSchema());

        self::assertSame(['formid'], $this->foreignKeyColumns());

        $this->createMigration()->up($this->introspectSchema());

        $localColumns = $this->foreignKeyColumns();

        self::assertContains('iduserscreator', $localColumns);
        self::assertContains('iduserschanger', $localColumns);
    }

    public function testUpDoesNothingWhenTheForeignKeysAreStillThere(): void
    {
        $before = $this->foreignKeyColumns();

        $this->createMigration()->up($this->introspectSchema());

        self::assertSame($before, $this->foreignKeyColumns());
    }

    private function createMigration(): Version20260824120000
    {
        return new Version20260824120000($this->connection, new NullLogger());
    }

    private function introspectSchema(): Schema
    {
        return $this->connection->createSchemaManager()->introspectSchema();
    }

    /**
     * @return list<string>
     */
    private function foreignKeyColumns(): array
    {
        $columns = [];

        foreach ($this->introspectSchema()->getTable('fo_dynamics')->getForeignKeys() as $foreignKey) {
            foreach ($foreignKey->getLocalColumns() as $localColumn) {
                $columns[] = \strtolower($localColumn);
            }
        }

        \sort($columns);

        return $columns;
    }
}

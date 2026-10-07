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
        $this->dropAuditForeignKeys();

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

    public function testUpNullsTheIdsOfDeletedUsers(): void
    {
        $this->dropAuditForeignKeys();

        $formId = $this->insertForm();
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');
        $this->connection->insert('fo_dynamics', [
            'type' => 'pages',
            'typeId' => 'orphan',
            'locale' => 'en',
            'webspaceKey' => 'sulu_io',
            'formId' => $formId,
            'idUsersCreator' => 999999,
            'idUsersChanger' => 999999,
            'created' => $now,
            'changed' => $now,
        ]);

        $this->createMigration()->up($this->introspectSchema());

        $localColumns = $this->foreignKeyColumns();

        self::assertContains('iduserscreator', $localColumns);
        self::assertContains('iduserschanger', $localColumns);
        self::assertSame(
            ['idUsersCreator' => null, 'idUsersChanger' => null],
            $this->connection->fetchAssociative(
                'SELECT idUsersCreator AS "idUsersCreator", idUsersChanger AS "idUsersChanger" FROM fo_dynamics WHERE typeId = ?',
                ['orphan'],
            ),
        );
    }

    private function createMigration(): Version20260824120000
    {
        return new Version20260824120000($this->connection, new NullLogger());
    }

    /**
     * Puts the table back in the state left by the faulty Version20260702120000.
     */
    private function dropAuditForeignKeys(): void
    {
        $table = $this->introspectSchema()->getTable('fo_dynamics');
        $newTable = clone $table;

        foreach ($newTable->getForeignKeys() as $foreignKey) {
            if (0 === \strcasecmp($foreignKey->getForeignTableName(), 'se_users')) {
                $newTable->removeForeignKey($foreignKey->getName());
            }
        }

        $diff = $this->connection->createSchemaManager()->createComparator()->compareTables($table, $newTable);

        foreach ($this->connection->getDatabasePlatform()->getAlterTableSQL($diff) as $sql) {
            $this->connection->executeStatement($sql);
        }
    }

    private function insertForm(): int
    {
        $this->connection->insert('fo_forms', ['defaultLocale' => 'en']);

        return (int) $this->connection->lastInsertId();
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

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
use Sulu\Bundle\FormBundle\Migrations\Version20260702120000;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class Version20260702120000Test extends SuluTestCase
{
    private Connection $connection;

    protected function setUp(): void
    {
        self::bootKernel();
        self::purgeDatabase();

        $this->connection = self::getEntityManager()->getConnection();

        // Revert to the pre-migration schema (nullable formId, ON DELETE SET NULL) so orphaned submissions
        // can be created for the test.
        $this->createMigration()->down($this->introspectSchema());
    }

    protected function tearDown(): void
    {
        // Restore the canonical schema so following tests are not affected.
        $this->createMigration()->up($this->introspectSchema());

        parent::tearDown();
    }

    public function testUpDeletesOrphanedSubmissionsAndKeepsLinkedOnes(): void
    {
        $formId = $this->insertForm();
        $this->insertDynamic('linked', $formId);
        $this->insertDynamic('orphan', null);

        $this->createMigration()->up($this->introspectSchema());

        self::assertSame(1, $this->countDynamic('linked'));
        self::assertSame(0, $this->countDynamic('orphan'));
    }

    public function testUpMakesFormRelationCascadeDeleteSubmissions(): void
    {
        $formId = $this->insertForm();
        $this->insertDynamic('linked', $formId);

        $this->createMigration()->up($this->introspectSchema());

        // Deleting the form now cascades to its submissions.
        $this->connection->delete('fo_forms', ['id' => $formId]);

        self::assertSame(0, $this->countDynamic('linked'));
    }

    private function createMigration(): Version20260702120000
    {
        return new Version20260702120000($this->connection, new NullLogger());
    }

    private function introspectSchema(): Schema
    {
        return $this->connection->createSchemaManager()->introspectSchema();
    }

    private function insertForm(): int
    {
        $this->connection->insert('fo_forms', ['defaultLocale' => 'en']);

        return (int) $this->connection->lastInsertId();
    }

    private function insertDynamic(string $typeId, ?int $formId): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $this->connection->insert('fo_dynamics', [
            'type' => 'pages',
            'typeId' => $typeId,
            'locale' => 'en',
            'webspaceKey' => 'sulu_io',
            'formId' => $formId,
            'created' => $now,
            'changed' => $now,
        ]);
    }

    private function countDynamic(string $typeId): int
    {
        return (int) $this->connection->fetchOne('SELECT COUNT(*) FROM fo_dynamics WHERE typeId = ?', [$typeId]);
    }
}

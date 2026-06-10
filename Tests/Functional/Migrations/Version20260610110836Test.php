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
use Sulu\Bundle\FormBundle\Migrations\Version20260610110836;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class Version20260610110836Test extends SuluTestCase
{
    private Connection $connection;

    protected function setUp(): void
    {
        self::bootKernel();
        self::purgeDatabase();

        $this->connection = self::getEntityManager()->getConnection();
    }

    public function testUpConvertsSingularTypesToPlural(): void
    {
        $this->insertDynamic('page', 'page-1');
        $this->insertDynamic('article', 'article-1');
        $this->insertDynamic('snippet', 'snippet-1');
        $this->insertDynamic('other', 'other-1');

        $this->createMigration()->up($this->introspectSchema());

        self::assertSame('pages', $this->typeOf('page-1'));
        self::assertSame('articles', $this->typeOf('article-1'));
        self::assertSame('snippets', $this->typeOf('snippet-1'));
        self::assertSame('other', $this->typeOf('other-1'));
    }

    public function testDownRevertsPluralTypesToSingular(): void
    {
        $this->insertDynamic('pages', 'page-1');
        $this->insertDynamic('articles', 'article-1');
        $this->insertDynamic('snippets', 'snippet-1');
        $this->insertDynamic('other', 'other-1');

        $this->createMigration()->down($this->introspectSchema());

        self::assertSame('page', $this->typeOf('page-1'));
        self::assertSame('article', $this->typeOf('article-1'));
        self::assertSame('snippet', $this->typeOf('snippet-1'));
        self::assertSame('other', $this->typeOf('other-1'));
    }

    public function testUpAndDownRoundtripToOriginalValue(): void
    {
        $this->insertDynamic('page', 'page-1');

        $migration = $this->createMigration();
        $migration->up($this->introspectSchema());
        $migration->down($this->introspectSchema());

        self::assertSame('page', $this->typeOf('page-1'));
    }

    private function createMigration(): Version20260610110836
    {
        return new Version20260610110836($this->connection, new NullLogger());
    }

    private function introspectSchema(): Schema
    {
        return $this->connection->createSchemaManager()->introspectSchema();
    }

    private function insertDynamic(string $type, string $typeId): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $this->connection->insert('fo_dynamics', [
            'type' => $type,
            'typeId' => $typeId,
            'locale' => 'en',
            'webspaceKey' => 'sulu_io',
            'created' => $now,
            'changed' => $now,
        ]);
    }

    private function typeOf(string $typeId): string
    {
        $type = $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', [$typeId]);
        self::assertIsString($type);

        return $type;
    }
}

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
use Psr\Log\NullLogger;
use Sulu\Bundle\FormBundle\Migrations\Version20260610000000;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class Version20260610000000Test extends SuluTestCase
{
    private Connection $connection;

    public function setUp(): void
    {
        static::purgeDatabase();
        static::bootKernel();

        $this->connection = static::getEntityManager()->getConnection();
    }

    public function testUpMigratesSingularTypesToPlural(): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $this->insertDynamic('page', 'page-1', $now);
        $this->insertDynamic('article', 'article-1', $now);
        $this->insertDynamic('snippet', 'snippet-1', $now);
        $this->insertDynamic('pages', 'pages-already', $now);
        $this->insertDynamic('other', 'other-1', $now);

        $migration = new Version20260610000000($this->connection, new NullLogger());
        $schema = $this->connection->createSchemaManager()->introspectSchema();

        $migration->up($schema);

        $this->assertSame(
            'pages',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['page-1'])
        );
        $this->assertSame(
            'articles',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['article-1'])
        );
        $this->assertSame(
            'snippets',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['snippet-1'])
        );
        $this->assertSame(
            'pages',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['pages-already']),
            'Already-plural rows must not change.'
        );
        $this->assertSame(
            'other',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['other-1']),
            'Unrelated type values must not change.'
        );
    }

    public function testDownRevertsPluralsToSingular(): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $this->insertDynamic('pages', 'page-down-1', $now);
        $this->insertDynamic('articles', 'article-down-1', $now);
        $this->insertDynamic('snippets', 'snippet-down-1', $now);

        $migration = new Version20260610000000($this->connection, new NullLogger());
        $schema = $this->connection->createSchemaManager()->introspectSchema();

        $migration->down($schema);

        $this->assertSame(
            'page',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['page-down-1'])
        );
        $this->assertSame(
            'article',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['article-down-1'])
        );
        $this->assertSame(
            'snippet',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['snippet-down-1'])
        );
    }

    public function testUpAndDownAreInverse(): void
    {
        $now = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

        $this->insertDynamic('page', 'roundtrip-1', $now);

        $migration = new Version20260610000000($this->connection, new NullLogger());
        $schema = $this->connection->createSchemaManager()->introspectSchema();

        $migration->up($schema);

        $this->assertSame(
            'pages',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['roundtrip-1'])
        );

        $migration->down($schema);

        $this->assertSame(
            'page',
            $this->connection->fetchOne('SELECT type FROM fo_dynamics WHERE typeId = ?', ['roundtrip-1'])
        );
    }

    private function insertDynamic(string $type, string $typeId, string $now): void
    {
        $this->connection->insert('fo_dynamics', [
            'type' => $type,
            'typeId' => $typeId,
            'locale' => 'en',
            'webspaceKey' => 'sulu_io',
            'created' => $now,
            'changed' => $now,
        ]);
    }
}

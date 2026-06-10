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

namespace Sulu\Bundle\FormBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migrate fo_dynamics.type from the legacy singular content-type keys to the plural
 * resourceKeys now used by the form title providers (page -> pages, etc.).
 */
final class Version20260610000000 extends AbstractMigration
{
    private const TABLE = 'fo_dynamics';

    /**
     * Legacy singular key => plural resourceKey.
     *
     * @var array<string, string>
     */
    private const TYPE_MAP = [
        'page' => 'pages',
        'article' => 'articles',
        'snippet' => 'snippets',
    ];

    public function getDescription(): string
    {
        return 'Migrate fo_dynamics.type from singular content-type keys to plural resourceKeys (page->pages, article->articles, snippet->snippets).';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable(self::TABLE)) {
            return;
        }

        foreach (self::TYPE_MAP as $singular => $plural) {
            $this->updateType($singular, $plural);
        }
    }

    public function down(Schema $schema): void
    {
        if (!$schema->hasTable(self::TABLE)) {
            return;
        }

        foreach (self::TYPE_MAP as $singular => $plural) {
            $this->updateType($plural, $singular);
        }
    }

    private function updateType(string $from, string $to): void
    {
        $this->connection->createQueryBuilder()
            ->update(self::TABLE)
            ->set('type', ':to')
            ->where('type = :from')
            ->setParameter('to', $to)
            ->setParameter('from', $from)
            ->executeStatement();
    }
}

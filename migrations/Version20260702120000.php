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

final class Version20260702120000 extends AbstractMigration
{
    private const TABLE = 'fo_dynamics';

    private const FORM_TABLE = 'fo_forms';

    public function getDescription(): string
    {
        return 'Delete orphaned form submissions and make the fo_dynamics form relation non-nullable with ON DELETE CASCADE.';
    }

    public function up(Schema $schema): void
    {
        // Remove orphaned submissions so the formId column can become NOT NULL.
        $this->connection->createQueryBuilder()
            ->delete(self::TABLE)
            ->where('formId IS NULL')
            ->executeStatement();

        $this->changeFormRelation($schema, true, 'CASCADE');
    }

    public function down(Schema $schema): void
    {
        // Only the schema is reverted here; the submissions deleted by up() cannot be restored.
        $this->changeFormRelation($schema, false, 'SET NULL');
    }

    private function changeFormRelation(Schema $schema, bool $notnull, string $onDelete): void
    {
        $table = $schema->getTable(self::TABLE);
        $newTable = clone $table;

        foreach ($newTable->getForeignKeys() as $foreignKey) {
            if (0 === \strcasecmp($foreignKey->getForeignTableName(), self::FORM_TABLE)) {
                $newTable->removeForeignKey($foreignKey->getName());
            }
        }

        $newTable->getColumn('formId')->setNotnull($notnull);
        $newTable->addForeignKeyConstraint(self::FORM_TABLE, ['formId'], ['id'], ['onDelete' => $onDelete]);

        $diff = $this->sm->createComparator()->compareTables($table, $newTable);

        foreach ($this->platform->getAlterTableSQL($diff) as $sql) {
            $this->connection->executeStatement($sql);
        }
    }
}

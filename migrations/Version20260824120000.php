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
use Doctrine\DBAL\Schema\Table;
use Doctrine\Migrations\AbstractMigration;

final class Version20260824120000 extends AbstractMigration
{
    private const TABLE = 'fo_dynamics';

    private const USER_TABLE = 'se_users';

    /**
     * @var list<string>
     */
    private const AUDIT_COLUMNS = ['idUsersCreator', 'idUsersChanger'];

    public function getDescription(): string
    {
        return 'Restore the fo_dynamics creator and changer foreign keys dropped by Version20260702120000.';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable(self::USER_TABLE)) {
            return;
        }

        $table = $schema->getTable(self::TABLE);
        $newTable = clone $table;

        foreach (self::AUDIT_COLUMNS as $column) {
            if (!$table->hasColumn($column) || $this->hasForeignKeyOn($table, $column)) {
                continue;
            }

            // Null the ids whose user was deleted while the key was missing, as ON DELETE SET NULL would have done,
            // otherwise adding the key fails on them.
            $this->connection->executeStatement(\sprintf(
                'UPDATE %1$s SET %2$s = NULL WHERE %2$s IS NOT NULL AND %2$s NOT IN (SELECT id FROM %3$s)',
                self::TABLE,
                $column,
                self::USER_TABLE,
            ));
            $newTable->addForeignKeyConstraint(self::USER_TABLE, [$column], ['id'], ['onDelete' => 'SET NULL']);
        }

        $this->applyDiff($table, $newTable);
    }

    public function down(Schema $schema): void
    {
        // The keys are owned by the entity mapping, so they are kept: up() may have skipped them as already there.
    }

    private function hasForeignKeyOn(Table $table, string $column): bool
    {
        foreach ($table->getForeignKeys() as $foreignKey) {
            foreach ($foreignKey->getLocalColumns() as $localColumn) {
                if (0 === \strcasecmp($localColumn, $column)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function applyDiff(Table $table, Table $newTable): void
    {
        $diff = $this->sm->createComparator()->compareTables($table, $newTable);

        foreach ($this->platform->getAlterTableSQL($diff) as $sql) {
            $this->connection->executeStatement($sql);
        }
    }
}

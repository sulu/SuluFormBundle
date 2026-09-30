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

            $newTable->addForeignKeyConstraint(self::USER_TABLE, [$column], ['id'], ['onDelete' => 'SET NULL']);
        }

        $this->applyDiff($table, $newTable);
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable(self::TABLE);
        $newTable = clone $table;

        foreach ($newTable->getForeignKeys() as $foreignKey) {
            if (0 === \strcasecmp($foreignKey->getForeignTableName(), self::USER_TABLE)) {
                $newTable->removeForeignKey($foreignKey->getName());
            }
        }

        $this->applyDiff($table, $newTable);
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

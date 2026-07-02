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

final class Version20260610170945 extends AbstractMigration
{
    private const TABLE = 'fo_form_fields';

    private const OLD_TYPE = 'sendinblue';

    private const NEW_TYPE = 'brevo';

    public function getDescription(): string
    {
        return 'Migrate fo_form_fields.type from the deprecated "sendinblue" type to "brevo".';
    }

    public function up(Schema $schema): void
    {
        $this->updateType(self::OLD_TYPE, self::NEW_TYPE);
    }

    public function down(Schema $schema): void
    {
        $this->updateType(self::NEW_TYPE, self::OLD_TYPE);
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

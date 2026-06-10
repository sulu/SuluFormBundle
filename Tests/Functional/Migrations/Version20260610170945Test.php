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
use Sulu\Bundle\FormBundle\Migrations\Version20260610170945;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class Version20260610170945Test extends SuluTestCase
{
    private Connection $connection;

    protected function setUp(): void
    {
        self::bootKernel();
        self::purgeDatabase();

        $this->connection = self::getEntityManager()->getConnection();
    }

    public function testUpRenamesSendinblueToBrevo(): void
    {
        $idForms = $this->insertForm();
        $this->insertFormField($idForms, 'sendinblue', 'sendinblue-field');
        $this->insertFormField($idForms, 'mailchimp', 'mailchimp-field');

        $this->createMigration()->up($this->introspectSchema());

        self::assertSame('brevo', $this->typeOf('sendinblue-field'));
        self::assertSame('mailchimp', $this->typeOf('mailchimp-field'));
    }

    public function testDownRevertsBrevoToSendinblue(): void
    {
        $idForms = $this->insertForm();
        $this->insertFormField($idForms, 'brevo', 'brevo-field');
        $this->insertFormField($idForms, 'mailchimp', 'mailchimp-field');

        $this->createMigration()->down($this->introspectSchema());

        self::assertSame('sendinblue', $this->typeOf('brevo-field'));
        self::assertSame('mailchimp', $this->typeOf('mailchimp-field'));
    }

    public function testUpAndDownRoundtripToOriginalValue(): void
    {
        $idForms = $this->insertForm();
        $this->insertFormField($idForms, 'sendinblue', 'sendinblue-field');

        $migration = $this->createMigration();
        $migration->up($this->introspectSchema());
        $migration->down($this->introspectSchema());

        self::assertSame('sendinblue', $this->typeOf('sendinblue-field'));
    }

    private function createMigration(): Version20260610170945
    {
        return new Version20260610170945($this->connection, new NullLogger());
    }

    private function introspectSchema(): Schema
    {
        return $this->connection->createSchemaManager()->introspectSchema();
    }

    private function insertForm(): int
    {
        $this->connection->insert('fo_forms', [
            'defaultLocale' => 'en',
        ]);

        return (int) $this->connection->lastInsertId();
    }

    private function insertFormField(int $idForms, string $type, string $key): void
    {
        $this->connection->insert('fo_form_fields', [
            'idForms' => $idForms,
            'keyName' => $key,
            'orderNumber' => 1,
            'type' => $type,
            'width' => 'full',
            'required' => 0,
            'defaultLocale' => 'en',
        ]);
    }

    private function typeOf(string $key): string
    {
        $type = $this->connection->fetchOne('SELECT type FROM fo_form_fields WHERE keyName = ?', [$key]);
        self::assertIsString($type);

        return $type;
    }
}

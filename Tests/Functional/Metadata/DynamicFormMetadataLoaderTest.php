<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Functional\Metadata;

use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use PHPUnit\Framework\Attributes\DataProvider;
use Sulu\Bundle\FormBundle\Metadata\DynamicFormMetadataLoader;
use Sulu\Bundle\TestBundle\Testing\SuluTestCase;

class DynamicFormMetadataLoaderTest extends SuluTestCase
{
    use PHPMatcherAssertions;

    private DynamicFormMetadataLoader $dynamicFormMetadataLoader;

    protected function setUp(): void
    {
        $this->dynamicFormMetadataLoader = $this->getContainer()->get('sulu_form_test.dynamic_form_metadata_loader');
    }

    #[DataProvider('dataLocale')]
    public function testGetMetadata(string $locale): void
    {
        $formMetadata = $this->dynamicFormMetadataLoader->getMetadata('form_details', 'en')?->getItems();

        $snapshotFilePath = sprintf(__DIR__.'/snapshots/%s.json', $locale);
        $content = self::getContainer()->get('serializer')->serialize($formMetadata, 'json');

        $this->assertFileExists($snapshotFilePath, 'Unable to find snapshot file: ' . $snapshotFilePath);
        $snapshotPattern = \file_get_contents($snapshotFilePath);
        $this->assertIsString($snapshotPattern, 'Unable to open snapshot file: ' . $snapshotFilePath);

        $this->assertMatchesPattern(\trim($snapshotPattern), \trim($content));
    }

    /** @return array<array{string}> */
    public function dataLocale(): array {
        return [
            'german' => ['de'],
            'english' => ['en'],
        ];
    }
}

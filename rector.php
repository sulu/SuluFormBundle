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

use Rector\Config\RectorConfig;
use Rector\PHPUnit\PHPUnit100\Rector\Class_\StaticDataProviderClassMethodRector;
use Rector\PHPUnit\Set\PHPUnitSetList;

return RectorConfig::configure()
    ->withRootFiles()
    ->withPaths([
        __DIR__,
    ])
    ->withSkipPath(__DIR__ . '/vendor')
    ->withSkipPath('*/var/cache')
    ->withSkipPath('*/Tests/Application/var')
    ->withPHPStanConfigs([
        __DIR__ . '/phpstan.neon',
    ])
    ->withSymfonyContainerXml(__DIR__ . '/Tests/Application/var/cache/admin/dev/Sulu_Bundle_FormBundle_Tests_Application_KernelDevDebugContainer.xml')
    ->withSets([
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
    ])
    ->withRules([
        StaticDataProviderClassMethodRector::class,
    ])
;

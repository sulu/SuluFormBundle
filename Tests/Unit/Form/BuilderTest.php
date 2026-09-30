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

namespace Sulu\Bundle\FormBundle\Tests\Unit\Form;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sulu\Bundle\FormBundle\Dynamic\Checksum;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypePool;
use Sulu\Bundle\FormBundle\Form\Builder;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPoolInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Service\ResetInterface;

class BuilderTest extends TestCase
{
    use ProphecyTrait;

    public function testItIsResettable(): void
    {
        $this->assertInstanceOf(ResetInterface::class, $this->createBuilder());
    }

    public function testResetClearsTheFormCache(): void
    {
        $builder = $this->createBuilder();
        $this->writeCache($builder, ['1__type__42__en__form' => $this->prophesize(FormInterface::class)->reveal()]);

        $builder->reset();

        $this->assertSame([], $this->readCache($builder));
    }

    public function testCacheIsKeptUntilResetIsCalled(): void
    {
        $builder = $this->createBuilder();
        $form = $this->prophesize(FormInterface::class)->reveal();
        $this->writeCache($builder, ['1__type__42__en__form' => $form]);

        $this->assertSame(['1__type__42__en__form' => $form], $this->readCache($builder));
    }

    private function createBuilder(): Builder
    {
        return new Builder(
            new RequestStack(),
            $this->prophesize(FormFieldTypePool::class)->reveal(),
            $this->prophesize(TitleProviderPoolInterface::class)->reveal(),
            $this->prophesize(FormRepository::class)->reveal(),
            $this->prophesize(FormFactory::class)->reveal(),
            $this->prophesize(Checksum::class)->reveal(),
            $this->prophesize(CsrfTokenManagerInterface::class)->reveal()
        );
    }

    /**
     * @param array<string, FormInterface<mixed>|null> $forms
     */
    private function writeCache(Builder $builder, array $forms): void
    {
        $property = new \ReflectionProperty(Builder::class, 'cache');
        $property->setAccessible(true);
        $property->setValue($builder, $forms);
    }

    /**
     * @return array<string, FormInterface<mixed>|null>
     */
    private function readCache(Builder $builder): array
    {
        $property = new \ReflectionProperty(Builder::class, 'cache');
        $property->setAccessible(true);
        $cache = $property->getValue($builder);

        return \is_array($cache) ? $cache : [];
    }
}

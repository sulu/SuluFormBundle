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

namespace Sulu\Bundle\FormBundle\Tests\Unit\Infrastructure\Sulu\Content\PropertyResolver;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\PropertyResolver\SingleFormSelectionPropertyResolver;
use Sulu\Content\Application\ContentResolver\Value\ResolvableResource;
use Symfony\Component\Form\FormView;

#[CoversClass(SingleFormSelectionPropertyResolver::class)]
class SingleFormSelectionPropertyResolverTest extends TestCase
{
    private SingleFormSelectionPropertyResolver $resolver;

    protected function setUp(): void
    {
        $this->resolver = new SingleFormSelectionPropertyResolver();
    }

    public function testResolveEmpty(): void
    {
        $contentView = $this->resolver->resolve(null, 'en');

        $this->assertNull($contentView->getContent());
        $this->assertSame(['id' => null], $contentView->getView());
    }

    public function testResolveParams(): void
    {
        $contentView = $this->resolver->resolve(null, 'en', ['custom' => 'params']);

        $this->assertNull($contentView->getContent());
        $this->assertSame(['id' => null, 'custom' => 'params'], $contentView->getView());
    }

    #[DataProvider('provideUnresolvableData')]
    public function testResolveUnresolvableData(mixed $data): void
    {
        $contentView = $this->resolver->resolve($data, 'en');

        $this->assertNull($contentView->getContent());
        $this->assertSame(['id' => null], $contentView->getView());
    }

    /**
     * @return iterable<string, array{mixed}>
     */
    public static function provideUnresolvableData(): iterable
    {
        yield 'null' => [null];
        yield 'smart_content' => [['source' => '123']];
        yield 'multi_value' => [[1]];
        yield 'object' => [(object) [1]];
    }

    #[DataProvider('provideResolvableData')]
    public function testResolveResolvableData(int|string $data, int $expectedId): void
    {
        $contentView = $this->resolver->resolve($data, 'en');

        $content = $contentView->getContent();
        $this->assertInstanceOf(ResolvableResource::class, $content);
        $this->assertSame($expectedId, $content->getId());
        $this->assertSame('form', $content->getResourceLoaderKey());

        $this->assertSame(['id' => $data], $contentView->getView());

        $references = $contentView->getReferences();
        $this->assertCount(1, $references);
        $this->assertSame($expectedId, $references[0]->getResourceId());
        $this->assertSame(Form::RESOURCE_KEY, $references[0]->getResourceKey());
    }

    /**
     * @return iterable<string, array{int|string, int}>
     */
    public static function provideResolvableData(): iterable
    {
        yield 'string' => ['5', 5];
        yield 'int' => [5, 5];
    }

    public function testCustomResourceLoader(): void
    {
        $contentView = $this->resolver->resolve('5', 'en', ['resourceLoader' => 'custom_form']);

        $content = $contentView->getContent();
        $this->assertInstanceOf(ResolvableResource::class, $content);
        $this->assertSame(5, $content->getId());
        $this->assertSame('custom_form', $content->getResourceLoaderKey());

        $references = $contentView->getReferences();
        $this->assertCount(1, $references);
        $this->assertSame(5, $references[0]->getResourceId());
        $this->assertSame(Form::RESOURCE_KEY, $references[0]->getResourceKey());
    }

    public function testResolveCallbackMapsStructToBuiltView(): void
    {
        $contentView = $this->resolver->resolve('5', 'en');
        $content = $contentView->getContent();
        $this->assertInstanceOf(ResolvableResource::class, $content);

        $formView = new FormView();
        $this->assertSame($formView, $content->executeResourceCallback(['view' => $formView, 'entity' => []]));
        $this->assertNull($content->executeResourceCallback(['view' => null, 'entity' => []]));
    }

    public function testGetType(): void
    {
        $this->assertSame('single_form_selection', SingleFormSelectionPropertyResolver::getType());
    }
}

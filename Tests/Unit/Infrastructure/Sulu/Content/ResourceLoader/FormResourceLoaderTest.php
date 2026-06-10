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

namespace Sulu\Bundle\FormBundle\Tests\Unit\Infrastructure\Sulu\Content\ResourceLoader;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\ResourceLoader\FormResourceLoader;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\FormBundle\TitleProvider\TitleProviderPoolInterface;
use Sulu\Content\Domain\Model\ContentRichEntityInterface;
use Sulu\Content\Domain\Model\DimensionContentInterface;
use Sulu\Content\Domain\Model\DimensionContentTrait;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FormResourceLoaderTest extends TestCase
{
    use ProphecyTrait;

    public function testLoadReturnsEmptyWhenLocaleIsNull(): void
    {
        $repository = $this->prophesize(FormRepository::class);
        $builder = $this->prophesize(BuilderInterface::class);
        $pool = $this->prophesize(TitleProviderPoolInterface::class)->reveal();
        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $pool, new RequestStack());

        $this->assertSame([], $loader->load(['1'], null));
    }

    public function testLoadBuildsViewAndSerializesEntityForPageObject(): void
    {
        $form = $this->createForm('en');
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds([5], 'en')->willReturn([$form]);

        $formView = new FormView();
        $builtForm = $this->prophesize(FormInterface::class);
        $builtForm->createView()->willReturn($formView);

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(5, 'pages', 'page-123', 'en', 'form')->shouldBeCalledOnce()->willReturn($builtForm->reveal());

        $pool = $this->prophesize(TitleProviderPoolInterface::class);
        $pool->has('pages')->willReturn(true);

        $resource = $this->prophesize(ContentRichEntityInterface::class);
        $resource->getId()->willReturn('page-123');

        $requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('object', new FormTestPageDimensionContent($resource->reveal()));
        $requestStack->push($request);

        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $pool->reveal(), $requestStack);

        $result = $loader->load(['5'], 'en');

        $this->assertSame($formView, $result[5]['view']);
        $this->assertSame('success-en', $result[5]['entity']['successText']);
    }

    public function testLoadReturnsNullViewWhenNoMainRequest(): void
    {
        $form = $this->createForm('en');
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds([5], 'en')->willReturn([$form]);

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(\Prophecy\Argument::cetera())->shouldNotBeCalled();

        $pool = $this->prophesize(TitleProviderPoolInterface::class)->reveal();
        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $pool, new RequestStack());

        $result = $loader->load(['5'], 'en');

        $this->assertNull($result[5]['view']);
        $this->assertSame('title-en', $result[5]['entity']['title']);
    }

    public function testLoadReturnsNullViewWhenObjectIsNotDimensionContent(): void
    {
        $form = $this->createForm('en');
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds([5], 'en')->willReturn([$form]);

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(\Prophecy\Argument::cetera())->shouldNotBeCalled();

        $pool = $this->prophesize(TitleProviderPoolInterface::class)->reveal();

        $requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('object', new \stdClass());
        $requestStack->push($request);

        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $pool, $requestStack);

        $result = $loader->load(['5'], 'en');

        $this->assertNull($result[5]['view']);
        $this->assertSame('title-en', $result[5]['entity']['title']);
    }

    public function testLoadReturnsNullViewWhenNoTitleProviderForResourceKey(): void
    {
        $form = $this->createForm('en');
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds([5], 'en')->willReturn([$form]);

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(\Prophecy\Argument::cetera())->shouldNotBeCalled();

        $pool = $this->prophesize(TitleProviderPoolInterface::class);
        $pool->has('snippets')->willReturn(false);

        $resource = $this->prophesize(ContentRichEntityInterface::class);
        $requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('object', new FormTestSnippetDimensionContent($resource->reveal()));
        $requestStack->push($request);

        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $pool->reveal(), $requestStack);

        $result = $loader->load(['5'], 'en');

        $this->assertNull($result[5]['view']);
    }

    public function testLoadFallsBackToShadowLocale(): void
    {
        $formDe = $this->createForm('de');
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds([5], 'en')->willReturn([]);
        $repository->loadByIds([5], 'de')->willReturn([$formDe]);

        $builder = $this->prophesize(BuilderInterface::class);
        $pool = $this->prophesize(TitleProviderPoolInterface::class)->reveal();
        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $pool, new RequestStack());

        $result = $loader->load(['5'], 'en', ['_shadowLocale' => 'de']);

        $this->assertArrayHasKey(5, $result);
        $this->assertNull($result[5]['view']);
        $this->assertSame('title-de', $result[5]['entity']['title']);
    }

    public function testResolveContentViewEnhancementExposesEntityOnViewSide(): void
    {
        $loader = new FormResourceLoader(
            $this->prophesize(FormRepository::class)->reveal(),
            $this->prophesize(BuilderInterface::class)->reveal(),
            $this->prophesize(TitleProviderPoolInterface::class)->reveal(),
            new RequestStack(),
        );

        $contentView = $loader->resolveContentViewEnhancement(['view' => null, 'entity' => ['successText' => 'hi']]);

        $this->assertSame([], $contentView->getContent());
        $this->assertSame(['entity' => ['successText' => 'hi']], $contentView->getView());
    }

    public function testGetKey(): void
    {
        $this->assertSame('form', FormResourceLoader::getKey());
    }

    private function createForm(string $locale): Form
    {
        $form = new Form();
        $form->setDefaultLocale($locale);

        // Form::setId() doesn't exist; set the private $id via reflection.
        (new \ReflectionProperty(Form::class, 'id'))->setValue($form, 5);

        $translation = new FormTranslation();
        $translation->setForm($form);
        $translation->setLocale($locale);
        $translation->setTitle('title-' . $locale);
        $translation->setSuccessText('success-' . $locale);
        $form->addTranslation($translation);

        return $form;
    }
}

class FormTestPageDimensionContent implements DimensionContentInterface
{
    use DimensionContentTrait;

    public function __construct(private ContentRichEntityInterface $resource)
    {
    }

    public function getResource(): ContentRichEntityInterface
    {
        return $this->resource;
    }

    public static function getResourceKey(): string
    {
        return 'pages';
    }
}

class FormTestSnippetDimensionContent implements DimensionContentInterface
{
    use DimensionContentTrait;

    public function __construct(private ContentRichEntityInterface $resource)
    {
    }

    public function getResource(): ContentRichEntityInterface
    {
        return $this->resource;
    }

    public static function getResourceKey(): string
    {
        return 'snippets';
    }
}

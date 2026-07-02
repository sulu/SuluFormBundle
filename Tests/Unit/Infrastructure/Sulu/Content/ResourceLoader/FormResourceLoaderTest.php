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

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;
use Sulu\Bundle\FormBundle\Form\BuilderInterface;
use Sulu\Bundle\FormBundle\Infrastructure\Sulu\Content\ResourceLoader\FormResourceLoader;
use Sulu\Bundle\FormBundle\Repository\FormRepository;
use Sulu\Bundle\TestBundle\Testing\SetGetPrivatePropertyTrait;
use Sulu\Page\Domain\Model\Page;
use Sulu\Page\Domain\Model\PageDimensionContent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

#[CoversClass(FormResourceLoader::class)]
class FormResourceLoaderTest extends TestCase
{
    use ProphecyTrait;
    use SetGetPrivatePropertyTrait;

    public function testLoadReturnsEmptyWhenLocaleIsNull(): void
    {
        $repository = $this->prophesize(FormRepository::class);
        $builder = $this->prophesize(BuilderInterface::class);
        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), new RequestStack());

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

        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $this->createRequestStack('page-123'));

        $result = $loader->load(['5'], 'en');

        $this->assertSame($formView, $result[5]['view']);
        $this->assertSame('success-en', $result[5]['entity']['successText']);
    }

    public function testLoadReturnsEmptyWhenNoMainRequest(): void
    {
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds(\Prophecy\Argument::cetera())->shouldNotBeCalled();

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(\Prophecy\Argument::cetera())->shouldNotBeCalled();

        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), new RequestStack());

        $this->assertSame([], $loader->load(['5'], 'en'));
    }

    public function testLoadReturnsEmptyWhenObjectIsNotDimensionContent(): void
    {
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds(\Prophecy\Argument::cetera())->shouldNotBeCalled();

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(\Prophecy\Argument::cetera())->shouldNotBeCalled();

        $requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('object', new \stdClass());
        $requestStack->push($request);

        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $requestStack);

        $this->assertSame([], $loader->load(['5'], 'en'));
    }

    public function testLoadReturnsNullEntryWhenBuilderReturnsNull(): void
    {
        $form = $this->createForm('en');
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds([5], 'en')->willReturn([$form]);

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(5, 'pages', 'page-123', 'en', 'form')->shouldBeCalledOnce()->willReturn(null);

        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $this->createRequestStack('page-123'));

        $result = $loader->load(['5'], 'en');

        $this->assertArrayHasKey(5, $result);
        $this->assertNull($result[5]);
    }

    public function testLoadFallsBackToShadowLocale(): void
    {
        $formDe = $this->createForm('de');
        $repository = $this->prophesize(FormRepository::class);
        $repository->loadByIds([5], 'en')->willReturn([]);
        $repository->loadByIds([5], 'de')->willReturn([$formDe]);

        $formView = new FormView();
        $builtForm = $this->prophesize(FormInterface::class);
        $builtForm->createView()->willReturn($formView);

        $builder = $this->prophesize(BuilderInterface::class);
        $builder->build(5, 'pages', 'page-123', 'de', 'form')->shouldBeCalledOnce()->willReturn($builtForm->reveal());

        $loader = new FormResourceLoader($repository->reveal(), $builder->reveal(), $this->createRequestStack('page-123'));

        $result = $loader->load(['5'], 'en', ['_shadowLocale' => 'de']);

        $this->assertArrayHasKey(5, $result);
        $this->assertSame($formView, $result[5]['view']);
        $this->assertSame('title-de', $result[5]['entity']['title']);
    }

    public function testResolveContentViewEnhancementExposesEntityOnViewSide(): void
    {
        $loader = new FormResourceLoader(
            $this->prophesize(FormRepository::class)->reveal(),
            $this->prophesize(BuilderInterface::class)->reveal(),
            new RequestStack(),
        );

        $contentView = $loader->resolveContentViewEnhancement(['view' => null, 'entity' => ['successText' => 'hi']]);

        $this->assertSame([], $contentView->getContent());
        $this->assertSame(['entity' => ['successText' => 'hi']], $contentView->getView());
    }

    public function testResolveContentViewEnhancementHandlesNullResource(): void
    {
        $loader = new FormResourceLoader(
            $this->prophesize(FormRepository::class)->reveal(),
            $this->prophesize(BuilderInterface::class)->reveal(),
            new RequestStack(),
        );

        $contentView = $loader->resolveContentViewEnhancement(null);

        $this->assertSame([], $contentView->getContent());
        $this->assertSame(['entity' => []], $contentView->getView());
    }

    public function testGetKey(): void
    {
        $this->assertSame('form', FormResourceLoader::getKey());
    }

    private function createRequestStack(string $pageId): RequestStack
    {
        $requestStack = new RequestStack();
        $request = new Request();
        $request->attributes->set('object', new PageDimensionContent(new Page($pageId)));
        $requestStack->push($request);

        return $requestStack;
    }

    private function createForm(string $locale): Form
    {
        $form = new Form();
        $form->setDefaultLocale($locale);

        static::setPrivateProperty($form, 'id', 5);

        $translation = new FormTranslation();
        $translation->setForm($form);
        $translation->setLocale($locale);
        $translation->setTitle('title-' . $locale);
        $translation->setSuccessText('success-' . $locale);
        $form->addTranslation($translation);

        return $form;
    }
}

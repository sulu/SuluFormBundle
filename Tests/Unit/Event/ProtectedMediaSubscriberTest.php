<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Tests\Unit\Event;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Sulu\Bundle\FormBundle\Event\ProtectedMediaSubscriber;
use Sulu\Bundle\FormBundle\Tests\Application\Kernel;
use Sulu\Bundle\MediaBundle\Media\FormatCache\FormatCacheInterface;
use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProtectedMediaSubscriberTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var EntityManagerInterface|ObjectProphecy
     */
    private $entityManager;

    /**
     * @var FormatCacheInterface|ObjectProphecy
     */
    private $formatCache;

    /**
     * @var UrlGeneratorInterface|ObjectProphecy
     */
    private $urlGenerator;

    /**
     * @var ProtectedMediaSubscriber
     */
    private $protectedMediaSubscriber;

    public function setUp(): void
    {
        $this->urlGenerator = $this->prophesize(UrlGeneratorInterface::class);
        $this->entityManager = $this->prophesize(EntityManagerInterface::class);
        $this->formatCache = $this->prophesize(FormatCacheInterface::class);

        $this->protectedMediaSubscriber = new ProtectedMediaSubscriber(
            $this->urlGenerator->reveal(),
            $this->entityManager->reveal(),
            $this->formatCache->reveal()
        );
    }

    public function testNoMasterRequest(): void
    {
        $request = new Request();
        $request->attributes->set('_route', 'other');

        $event = new RequestEvent(
            new Kernel('test', true, SuluKernel::CONTEXT_WEBSITE),
            $request,
            HttpKernelInterface::SUB_REQUEST
        );

        $this->formatCache->analyzedMediaUrl(Argument::any())
            ->shouldNotBeCalled();

        $this->protectedMediaSubscriber->onRequest($event);
    }

    public function testOtherRoute(): void
    {
        $request = new Request();
        $request->attributes->set('_route', 'other');

        $event = new RequestEvent(
            new Kernel('test', true, SuluKernel::CONTEXT_WEBSITE),
            $request,
            \defined(HttpKernelInterface::class . '::MASTER_REQUEST')
                ? HttpKernelInterface::MASTER_REQUEST
                : HttpKernelInterface::MAIN_REQUEST
        );

        $this->formatCache->analyzedMediaUrl(Argument::any())
            ->shouldNotBeCalled();

        $this->protectedMediaSubscriber->onRequest($event);
    }

    public function testImageProxyRoute(): void
    {
        $this->expectException(AccessDeniedHttpException::class);

        $request = new Request();
        $request->attributes->set('_route', 'sulu_media.website.image.proxy');
        $request->server->set('REQUEST_URI', '/uploads/media/50x50/2-test-image.jpg');
        $request->attributes->set('slug', '/50x50/2-test-image.jpg');

        $event = new RequestEvent(
            new Kernel('test', true, SuluKernel::CONTEXT_WEBSITE),
            $request,
            \defined(HttpKernelInterface::class . '::MASTER_REQUEST')
                ? HttpKernelInterface::MASTER_REQUEST
                : HttpKernelInterface::MAIN_REQUEST
        );

        $this->formatCache->analyzedMediaUrl(Argument::any())
            ->willReturn([
                'id' => 1,
                'format' => '50x50',
                'fileName' => 'test-image',
            ])
            ->shouldBeCalled();

        $this->mockLoadCollectionKey('sulu_form');

        $this->protectedMediaSubscriber->onRequest($event);
    }

    public function testDownloadRoute(): void
    {
        $request = new Request();
        $request->attributes->set('_route', 'sulu_media.website.media.download');
        $request->server->set('REQUEST_URI', '/media/2/download/test-image.jpg');
        $request->attributes->set('id', '2');
        $request->attributes->set('_route_params', ['id' => '2', 'slug' => 'test-image.jpg']);
        $request->query->set('v', '3');

        $event = new RequestEvent(
            new Kernel('test', true, SuluKernel::CONTEXT_WEBSITE),
            $request,
            \defined(HttpKernelInterface::class . '::MASTER_REQUEST')
                ? HttpKernelInterface::MASTER_REQUEST
                : HttpKernelInterface::MAIN_REQUEST
        );

        $this->mockLoadCollectionKey('sulu_form');

        $this->urlGenerator->generate(
            'sulu_media.website.media.download_admin',
            [
                'id' => '2',
                'slug' => 'test-image.jpg',
                'v' => '3',
            ]
        )->shouldBeCalled()
            ->willReturn('/admin/media/2/download/test-image.jpg');

        $this->protectedMediaSubscriber->onRequest($event);

        $response = $event->getResponse();
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame('/admin/media/2/download/test-image.jpg', $response->getTargetUrl());
    }

    private function mockLoadCollectionKey(string $collectionKey): void
    {
        $queryBuilder = $this->prophesize(QueryBuilder::class);
        $this->entityManager->createQueryBuilder()
            ->willReturn($queryBuilder->reveal())
            ->shouldBeCalled();
        $queryBuilder->from(Argument::cetera())
            ->willReturn($queryBuilder->reveal())
            ->shouldBeCalled();
        $queryBuilder->innerJoin(Argument::cetera())
            ->willReturn($queryBuilder->reveal())
            ->shouldBeCalled();
        $queryBuilder->where(Argument::cetera())
            ->willReturn($queryBuilder->reveal())
            ->shouldBeCalled();
        $queryBuilder->select(Argument::cetera())
            ->willReturn($queryBuilder->reveal())
            ->shouldBeCalled();
        $queryBuilder->setParameter(Argument::cetera())
            ->willReturn($queryBuilder->reveal())
            ->shouldBeCalled();

        $query = new class($collectionKey) {
            /** @var string string */
            private $collectionKey;

            public function __construct(string $collectionKey)
            {
                $this->collectionKey = $collectionKey;
            }

            public function getSingleScalarResult(): string
            {
                return $this->collectionKey;
            }
        };

        $queryBuilder->getQuery()
            ->willReturn($query)
            ->shouldBeCalled();
    }
}

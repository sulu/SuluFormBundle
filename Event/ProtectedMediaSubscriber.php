<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\MediaBundle\Media\FormatCache\FormatCacheInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @internal
 */
class ProtectedMediaSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FormatCacheInterface
     */
    private $formatCache;

    /**
     * @var string[]
     */
    protected $protectedCollectionKeys = [];

    /**
     * @param string[] $protectedCollectionKeys
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        EntityManagerInterface $entityManager,
        FormatCacheInterface $formatCache,
        array $protectedCollectionKeys = [
            'sulu_form',
        ]
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
        $this->formatCache = $formatCache;
        $this->protectedCollectionKeys = $protectedCollectionKeys;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onRequest',
        ];
    }

    public function onRequest(RequestEvent $event): void
    {
        if (\method_exists($event, 'isMainRequest') ? !$event->isMainRequest() : !$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $routeName = $request->attributes->get('_route');

        if ('sulu_media.website.image.proxy' !== $routeName
            && 'sulu_media.website.media.download' !== $routeName
        ) {
            return;
        }

        $mediaId = null;

        if ('sulu_media.website.image.proxy' === $routeName) {
            $slug = $request->attributes->get('slug');

            if (!$slug) {
                return;
            }

            $mediaProperties = $this->formatCache->analyzedMediaUrl($request->getPathInfo());
            $mediaId = $mediaProperties['id'];
        }

        if (!$mediaId) {
            /** @var string|null $mediaId */
            $mediaId = $request->attributes->get('id');
        }

        if (!\is_numeric($mediaId) || !$this->isProtectedCollection((int) $mediaId)) {
            return;
        }

        if ('sulu_media.website.image.proxy' === $routeName) {
            throw new AccessDeniedHttpException();
        }

        $url = $this->urlGenerator->generate(
            'sulu_media.website.media.download_admin',
            \array_merge(
                $request->query->all(),
                $request->attributes->get('_route_params')
            )
        );

        $event->setResponse(new RedirectResponse($url));
    }

    private function isProtectedCollection(int $mediaId): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->from(MediaInterface::class, 'media')
            ->innerJoin('media.collection', 'collection')
            ->select('collection.key')
            ->where('media.id = :id')
            ->setParameter('id', $mediaId);

        try {
            $collectionKey = $queryBuilder->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
            return false;
        }

        foreach ($this->protectedCollectionKeys as $protectedCollectionKey) {
            if (0 === \strpos($collectionKey, $protectedCollectionKey)) {
                return true;
            }
        }

        return false;
    }
}

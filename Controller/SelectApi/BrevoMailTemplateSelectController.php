<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Controller\SelectApi;

use Brevo\Brevo;
use Brevo\Exceptions\BrevoException;
use Brevo\TransactionalEmails\Requests\GetSmtpTemplatesRequest;
use Psr\Http\Client\ClientExceptionInterface;
use Sulu\Component\Rest\ListBuilder\PaginatedRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
final class BrevoMailTemplateSelectController
{
    private const PAGE_SIZE = 100;

    public const RESOURCE_KEY = 'brevo_mail_template_select';

    public function __construct(private Brevo $api)
    {
    }

    /**
     * Returns array of Brevo mail templates of given account defined by the API key.
     */
    public function cgetAction(Request $request): JsonResponse
    {
        $limit = \max(1, (int) $request->query->get('limit', '100'));
        $page = \max(1, (int) $request->query->get('page', '1'));
        $search = (string) $request->query->get('search', '');

        $all = $this->fetchAll();

        if ('' !== $search) {
            $all = \array_values(\array_filter(
                $all, fn (array $item): bool => false !== \stripos((string) $item['title'], $search)
            ));
        }

        $total = \count($all);
        $items = \array_slice($all, ($page - 1) * $limit, $limit);

        return new JsonResponse(
            (new PaginatedRepresentation($items, self::RESOURCE_KEY, $page, $limit, $total))->toArray()
        );
    }

    /**
     * @return array<array{id: mixed, title: string}>
     */
    private function fetchAll(): array
    {
        $offset = 0;
        $mailTemplateObjects = [];

        while (true) {
            $response = $this->api->transactionalEmails->getSmtpTemplates(
                new GetSmtpTemplatesRequest(['limit' => self::PAGE_SIZE, 'offset' => $offset])
            );

            if (null === $response || 0 === $response->count || null === $response->templates) {
                break;
            }

            $mailTemplateObjects = [...$mailTemplateObjects, ...$response->templates];
            $offset += self::PAGE_SIZE;
        }

        $mailTemplates = [];
        foreach ($mailTemplateObjects as $template) {
            if ('optin' !== $template->tag) {
                continue;
            }

            $mailTemplates[] = [
                'id' => $template->id,
                'title' => $template->name,
            ];
        }

        return $mailTemplates;
    }

    public function getAction(int $id): JsonResponse
    {
        try {
            $response = $this->api->transactionalEmails->getSmtpTemplate($id);
            \assert(null !== $response);

            return new JsonResponse(['id' => $response->id, 'title' => $response->name]);
        } catch (BrevoException $e) {
            $previous = $e->getPrevious();
            if ($previous instanceof ClientExceptionInterface) {
                return new JsonResponse([], Response::HTTP_NOT_FOUND);
            }
            throw $e;
        }
    }
}

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
use Sulu\Component\Rest\ListBuilder\CollectionRepresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function cgetAction(): JsonResponse
    {
        $offset = 0;
        $mailTemplateObjects = [];

        while (true) {
            $response = $this->api->transactionalEmails->getSmtpTemplates(
                new GetSmtpTemplatesRequest(['limit' => self::PAGE_SIZE, 'offset' => $offset])
            );

            if (null === $response || 0 === $response->count) {
                break;
            }

            $mailTemplateObjects = [...$mailTemplateObjects, ...($response->templates ?? [])];
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

        return new JsonResponse((new CollectionRepresentation($mailTemplates, self::RESOURCE_KEY))->toArray());
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

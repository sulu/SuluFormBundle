<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Domain\Event;

use Sulu\Bundle\ActivityBundle\Domain\Event\DomainEvent;
use Sulu\Bundle\FormBundle\Admin\FormAdmin;
use Sulu\Bundle\FormBundle\Entity\Form;
use Sulu\Bundle\FormBundle\Entity\FormTranslation;

class FormRestoredEvent extends DomainEvent
{
    /**
     * @var Form
     */
    private $form;

    /**
     * @var mixed[]
     */
    private $payload;

    /**
     * @param mixed[] $payload
     */
    public function __construct(
        Form $form,
        array $payload
    ) {
        parent::__construct();

        $this->form = $form;
        $this->payload = $payload;
    }

    public function getForm(): Form
    {
        return $this->form;
    }

    public function getEventType(): string
    {
        return 'restored';
    }

    public function getEventPayload(): ?array
    {
        return $this->payload;
    }

    public function getResourceKey(): string
    {
        return Form::RESOURCE_KEY;
    }

    public function getResourceId(): string
    {
        return (string) $this->form->getId();
    }

    public function getResourceTitle(): ?string
    {
        $translation = $this->getFormTranslation();

        return $translation ? $translation->getTitle() : null;
    }

    public function getResourceTitleLocale(): ?string
    {
        $translation = $this->getFormTranslation();

        return $translation ? $translation->getLocale() : null;
    }

    private function getFormTranslation(): ?FormTranslation
    {
        return $this->form->getTranslation($this->form->getDefaultLocale());
    }

    public function getResourceSecurityContext(): ?string
    {
        return FormAdmin::SECURITY_CONTEXT;
    }
}

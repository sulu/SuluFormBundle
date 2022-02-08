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

class FormRemovedEvent extends DomainEvent
{
    /**
     * @var int
     */
    private $formId;

    /**
     * @var string|null
     */
    private $formTitle;

    /**
     * @var string|null
     */
    private $formTitleLocale;

    public function __construct(
        int $formId,
        ?string $categoryTitle,
        ?string $categoryTitleLocale
    ) {
        parent::__construct();

        $this->formId = $formId;
        $this->formTitle = $categoryTitle;
        $this->formTitleLocale = $categoryTitleLocale;
    }

    public function getEventType(): string
    {
        return 'removed';
    }

    public function getResourceKey(): string
    {
        return Form::RESOURCE_KEY;
    }

    public function getResourceId(): string
    {
        return (string) $this->formId;
    }

    public function getResourceTitle(): ?string
    {
        return $this->formTitle;
    }

    public function getResourceTitleLocale(): ?string
    {
        return $this->formTitleLocale;
    }

    public function getResourceSecurityContext(): ?string
    {
        return FormAdmin::SECURITY_CONTEXT;
    }
}

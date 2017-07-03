<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Event;

use Sulu\Bundle\FormBundle\Configuration\FormConfigurationInterface;
use Symfony\Component\Form\FormEvent as SymfonyFormEvent;
use Symfony\Component\Form\FormInterface;

/**
 * Sulu form event.
 */
class FormEvent extends SymfonyFormEvent
{
    /**
     * @var FormConfigurationInterface
     */
    private $configuration;

    /**
     * FormEvent constructor.
     *
     * @param FormInterface $form
     * @param FormConfigurationInterface $configuration
     */
    public function __construct(FormInterface $form, FormConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;

        parent::__construct($form, $form->getData());
    }

    /**
     * Get configuration.
     *
     * @return FormConfigurationInterface
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}

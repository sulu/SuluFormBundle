<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Configuration;

/**
 * Form config object to hold static and dynamic form configuration.
 */
class FormConfiguration implements FormConfigurationInterface
{
    /**
     * @var bool
     */
    private $save = true;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var int[]
     */
    private $fileFields = [];

    /**
     * @var MailConfigurationInterface
     */
    private $adminMailConfiguration;

    /**
     * @var MailConfigurationInterface
     */
    private $websiteMailConfiguration;

    public function __construct(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminMailConfiguration(): ?MailConfigurationInterface
    {
        return $this->adminMailConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsiteMailConfiguration(): ?MailConfigurationInterface
    {
        return $this->websiteMailConfiguration;
    }

    /**
     * Set admin mail configuration.
     *
     * @param MailConfigurationInterface $adminMailConfiguration
     *
     * @return $this
     */
    public function setAdminMailConfiguration(MailConfigurationInterface $adminMailConfiguration = null)
    {
        $this->adminMailConfiguration = $adminMailConfiguration;

        return $this;
    }

    /**
     * Set website mail configuration.
     *
     * @param MailConfigurationInterface $websiteMailConfiguration
     *
     * @return $this
     */
    public function setWebsiteMailConfiguration(MailConfigurationInterface $websiteMailConfiguration = null)
    {
        $this->websiteMailConfiguration = $websiteMailConfiguration;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFileFields(): array
    {
        return $this->fileFields;
    }

    /**
     * Set fileFields.
     *
     * @param int[] $fileFields
     *
     * @return $this
     */
    public function setFileFields(array $fileFields)
    {
        $this->fileFields = $fileFields;

        return $this;
    }

    public function getSave(): bool
    {
        return $this->save;
    }

    public function setSave(bool $save): self
    {
        $this->save = $save;

        return $this;
    }
}

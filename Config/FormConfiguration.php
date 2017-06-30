<?php

namespace Sulu\Bundle\FormBundle\Config;

/**
 * Form config object to hold static and dynamic form configuration.
 */
class FormConfiguration implements FormConfigurationInterface
{
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

    /**
     * FormConfigurationTranslation constructor.
     *
     * @param string $locale
     */
    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminMailConfiguration()
    {
        return $this->adminMailConfiguration;
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsiteMailConfiguration()
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
    public function getFileFields()
    {
        return $this->fileFields;
    }

    /**
     * Set fileFields.
     *
     * @param \int[] $fileFields
     *
     * @return $this
     */
    public function setFileFields($fileFields)
    {
        $this->fileFields = $fileFields;

        return $this;
    }
}

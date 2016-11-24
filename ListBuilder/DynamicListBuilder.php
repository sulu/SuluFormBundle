<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace L91\Sulu\Bundle\FormBundle\ListBuilder;

use L91\Sulu\Bundle\FormBundle\Entity\Dynamic;
use Symfony\Component\Routing\RouterInterface;

/**
 * Dynamic list builder.
 */
class DynamicListBuilder implements DynamicListBuilderInterface
{
    /**
     * @var string
     */
    protected $delimiter;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var string
     */
    protected $downloadUrl;

    /**
     * DynamicListResolver constructor.
     *
     * @param string $delimiter
     * @param RouterInterface $router
     */
    public function __construct($delimiter, $router)
    {
        $this->delimiter = $delimiter;
        $this->router = $router;
    }

    /**
     * @param Dynamic $dynamic
     * @param $locale
     *
     * @return array
     */
    public function build(Dynamic $dynamic, $locale)
    {
        $entry = $dynamic->getFields();

        $singleEntry = [
            'id' => $dynamic->getId(),
        ];

        foreach ($entry as $key => $value) {
            if ($dynamic->getType($key) === Dynamic::TYPE_ATTACHMENT) {
                $singleEntry[$key] = $this->getMediaUrls($value);
            } else {
                $singleEntry[$key] = $this->toString($value);
            }
        }

        $singleEntry['created'] = $dynamic->getCreated()->format('c');

        return [$singleEntry];
    }

    /**
     * Convert value to string.
     *
     * @param string|array $value
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function toString($value)
    {
        if (!$value) {
            return '';
        }

        if (is_string($value) || is_numeric($value)) {
            return $value;
        }

        if (is_bool($value)) {
            return $value ? 1 : 0;
        }

        if ($value instanceof \DateTime) {
            return $value->format('c');
        }

        if (!is_array($value)) {
            throw new \Exception('Invalid value for list builder.');
        }

        return implode($this->delimiter, $value);
    }

    /**
     * Get media urls.
     *
     * @param string $value
     *
     * @return string
     */
    protected function getMediaUrls($value)
    {
        if (is_string($value)) {
            return $this->getMediaUrl($value);
        }

        if (is_array($value)) {
            foreach ($value as $key => $mediaId) {
                $value[$key] = $this->getMediaUrl($mediaId);
            }

            return implode($this->delimiter, $value);
        }

        return $this->toString($value);
    }

    /**
     * Get media url.
     *
     * @param string $value
     *
     * @return string
     */
    protected function getMediaUrl($value)
    {
        return str_replace(urlencode('{id}'), $value, $this->getDownloadUrl());
    }

    /**
     * For performance generate route only once.
     *
     * @return string
     */
    protected function getDownloadUrl()
    {
        if ($this->downloadUrl === null) {
            $this->downloadUrl = $this->router->generate(
                'sulu_media.website.media.download',
                [
                    'slug' => 'file',
                    'id' => '{id}',
                ],
                true
            );
        }

        return $this->downloadUrl;
    }
}

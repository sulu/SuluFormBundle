<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType as TypeCheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * The Mailchimp form field type.
 */
class MailchimpType implements FormFieldTypeInterface
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return new FormFieldTypeConfiguration(
            'sulu_form.type.mailchimp',
            'SuluFormBundle:forms:fields/types/mailchimp.html.twig',
            ['mailChimpLists' => $this->getMailChimpLists()],
            'special'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $type = TypeCheckboxType::class;
        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValue(FormField $field, $locale)
    {
        return $field->getTranslation($locale)->getDefaultValue();
    }

    /**
     * Returns array of Mailchimp lists of given account defined by the API key.
     *
     * @return array
     */
    private function getMailChimpLists()
    {
        $lists = [];

        // If Milchimp class doesn't exist or no key is set return empty list.
        if (!class_exists(\DrewM\MailChimp\MailChimp::class) || !$this->apiKey) {
            return $lists;
        }

        $mailChimp = new \DrewM\MailChimp\MailChimp($this->apiKey);
        $response = $mailChimp->get('lists', ['count' => 100]);

        if (!isset($response['lists'])) {
            return $lists;
        }

        foreach ($response['lists'] as $list) {
            $lists[] = [
                'id' => $list['id'],
                'name' => $list['name'],
            ];
        }

        return $lists;
    }
}

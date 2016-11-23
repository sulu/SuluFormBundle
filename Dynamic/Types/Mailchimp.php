<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Types;

use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeInterface;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class Mailchimp implements FormFieldTypeInterface
{
    const TYPE_ALIAS = 'mailchimp';

    private $apiKey;

    /**
     * @param string $apiKey.
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return self::TYPE_ALIAS;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return 'SuluFormBundle:forms:fields/types/mailchimp.html.twig';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param FormField $field
     * @param string $locale
     * @param array $options
     */
    public function build(FormBuilderInterface $builder, FormField $field, $locale, $options)
    {
        $name = $field->getKey();
        $type = CheckboxType::class;

        $builder->add($field->getKey(), $type, $options);
    }

    /**
     * @return array
     */
    public function getViewData()
    {
        return ['mailChimpLists' => $this->getMailChimpLists()];
    }

    /**
     * @return array
     */
    private function getMailChimpLists()
    {
        $lists = [];

        // If mailchimp class doesn't exist or no key is set return empty list.
        if (!class_exists(\DrewM\MailChimp\MailChimp::class) || !$this->apiKey) {
            return $lists;
        }

        $mailChimp = new \DrewM\MailChimp\MailChimp($this->apiKey);
        $response = $mailChimp->get('lists');

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

<?php

namespace Sulu\Bundle\FormBundle\Entity;

use Sulu\Component\Persistence\Model\TimestampableInterface;

class Dynamic implements TimestampableInterface
{
    const TYPE_ATTACHMENT = 'attachment';

    protected static $arrayTypes = [
        'checkboxMultiple',
        'dropdownMultiple',
        'attachment',
    ];

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var Form
     */
    private $form;

    /**
     * @var string
     */
    private $webspaceKey;

    /**
     * @var string
     */
    private $salutation;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $function;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $textarea;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $attachment;

    /**
     * @var string
     */
    private $checkbox;

    /**
     * @var string
     */
    private $checkboxMultiple;

    /**
     * @var string
     */
    private $dropdown;

    /**
     * @var string
     */
    private $dropdownMultiple;

    /**
     * @var string
     */
    private $radioButtons;

    /**
     * @var string
     */
    private $data = '[]';

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $changed;

    /**
     * @param string $uuid
     * @param string $locale
     * @param Form $formId
     * @param null|string $webspaceKey
     * @param array $data
     */
    public function __construct($uuid, $locale, $formId, $webspaceKey = null, $data = [])
    {
        $this->uuid = $uuid;
        $this->locale = $locale;
        $this->form = $formId;
        $this->webspaceKey = $webspaceKey;

        foreach ($data as $name => $value) {
            $this->__set($name, $value);
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return json_decode($this->data, true);
    }

    /**
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            if (in_array($name, self::$arrayTypes)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }

            $this->$name = $value;
        } else {
            $array = $this->getData();
            $array[$name] = $value;

            $this->data = json_encode($array, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($name)
    {
        if (!is_string($name)) {
            return false;
        }

        if (property_exists($this, $name) && $this->$name !== null) {
            return true;
        }

        $data = $this->getData();

        return isset($data[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            if (in_array($name, self::$arrayTypes)) {
                if (!is_string($this->$name)) {
                    return;
                }

                return json_decode($this->$name, true);
            }

            return $this->$name;
        }

        $array = $this->getData();

        if (isset($array[$name])) {
            if (strpos($name, 'date') === 0) {
                return new \DateTime($array[$name]);
            }

            return $array[$name];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function getChanged()
    {
        return $this->changed;
    }
}

<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

use Sulu\Component\Persistence\Model\TimestampableInterface;

class Dynamic implements TimestampableInterface
{
    const TYPE_SPACER = 'spacer';
    const TYPE_FREE_TEXT = 'freeText';
    const TYPE_SALUTATION = 'salutation';
    const TYPE_TITLE = 'title';
    const TYPE_FIRST_NAME = 'firstName';
    const TYPE_LAST_NAME = 'lastName';
    const TYPE_EMAIL = 'email';
    const TYPE_PHONE = 'phone';
    const TYPE_FAX = 'fax';
    const TYPE_STREET = 'street';
    const TYPE_ZIP = 'zip';
    const TYPE_CITY = 'city';
    const TYPE_STATE = 'state';
    const TYPE_COUNTRY = 'country';
    const TYPE_FUNCTION = 'function';
    const TYPE_COMPANY = 'company';
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_DATE = 'date';
    const TYPE_HEADLINE = 'headline';
    const TYPE_ATTACHMENT = 'attachment';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_CHECKBOX_MULTIPLE = 'checkboxMultiple';
    const TYPE_DROPDOWN = 'dropdown';
    const TYPE_DROPDOWN_MULTIPLE = 'dropdownMultiple';
    const TYPE_RADIO_BUTTONS = 'radioButtons';
    const TYPE_MAILCHIMP = 'mailchimp';

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
     * @var array
     */
    public static $TYPES = [
        self::TYPE_SPACER,
        self::TYPE_FREE_TEXT,
        self::TYPE_SALUTATION,
        self::TYPE_TITLE,
        self::TYPE_FIRST_NAME,
        self::TYPE_LAST_NAME,
        self::TYPE_EMAIL,
        self::TYPE_PHONE,
        self::TYPE_FAX,
        self::TYPE_STREET,
        self::TYPE_ZIP,
        self::TYPE_CITY,
        self::TYPE_STATE,
        self::TYPE_COUNTRY,
        self::TYPE_FUNCTION,
        self::TYPE_COMPANY,
        self::TYPE_TEXT,
        self::TYPE_TEXTAREA,
        self::TYPE_DATE,
        self::TYPE_HEADLINE,
        self::TYPE_ATTACHMENT,
        self::TYPE_CHECKBOX,
        self::TYPE_CHECKBOX_MULTIPLE,
        self::TYPE_DROPDOWN,
        self::TYPE_DROPDOWN_MULTIPLE,
        self::TYPE_RADIO_BUTTONS,
    ];

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
            $this->$name = $value;
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
            if (is_array($value)) {
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
            if (in_array($name, [self::TYPE_CHECKBOX_MULTIPLE, self::TYPE_DROPDOWN_MULTIPLE, self::TYPE_ATTACHMENT])) {
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

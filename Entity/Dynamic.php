<?php

namespace Sulu\Bundle\FormBundle\Entity;

use Sulu\Component\Persistence\Model\TimestampableInterface;

class Dynamic implements TimestampableInterface
{
    const TYPE_ATTACHMENT = 'attachment';

    protected static $ARRAY_TYPES = [
        'checkboxMultiple',
        'dropdownMultiple',
        self::TYPE_ATTACHMENT,
    ];

    protected static $HIDDEN_TYPES = [
        'spacer',
        'headline',
        'freeText',
        'recaptcha',
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
     * @var string
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
            if (in_array($name, self::$ARRAY_TYPES)) {
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
        return $this->getField($name);
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

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get form.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get field.
     *
     * @param string $key
     *
     * @return string|array
     */
    public function getField($key)
    {
        if (property_exists($this, $key)) {
            if (in_array($key, self::$ARRAY_TYPES)) {
                if (!is_string($this->$key)) {
                    return;
                }

                return json_decode($this->$key, true);
            }

            return $this->$key;
        }

        $array = $this->getData();

        if (isset($array[$key])) {
            return $array[$key];
        }
    }

    /**
     * Get fields.
     *
     * @param bool $hideHidden
     *
     * @return array
     */
    public function getFields($hideHidden = false)
    {
        $entry = [];

        if (!$this->form) {
            return [];
        }

        foreach ($this->form->getFields() as $field) {
            if ($hideHidden && in_array($field->getType(), self::$HIDDEN_TYPES)) {
                continue;
            }

            $entry[$field->getKey()] = $this->getField($field->getKey());
        }

        return $entry;
    }

    /**
     * Get fields by type.
     *
     * @param string $type
     *
     * @return array
     */
    public function getFieldsByType($type)
    {
        $entry = [];

        if (!$this->form) {
            return [];
        }

        foreach ($this->form->getFieldsByType($type) as $field) {
            $entry[$field->getKey()] = $this->getField($field->getKey());
        }

        return $entry;
    }

    /**
     * Get type.
     *
     * @param string $key
     *
     * @return string
     */
    public function getType($key)
    {
        if (!$this->form) {
            return;
        }

        return $this->form->getFieldType($key);
    }
}

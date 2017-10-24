<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Entity;

use Sulu\Component\Persistence\Model\AuditableInterface;

class Dynamic implements AuditableInterface
{
    const TYPE_ATTACHMENT = 'attachment';
    const TYPE_EMAIL = 'email';

    protected static $ARRAY_TYPES = [
        'checkboxMultiple',
        'dropdownMultiple',
        self::TYPE_ATTACHMENT,
    ];

    public static $HIDDEN_TYPES = [
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
    private $type;

    /**
     * @var string
     */
    private $typeId;

    /**
     * @var string
     */
    private $typeName;

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
     * @var
     */
    private $creator;

    /**
     * @var
     */
    private $changer;

    /**
     * Dynamic constructor.
     *
     * @param string $type
     * @param string $typeId
     * @param string $locale
     * @param Form $form
     * @param array $data
     * @param string $webspaceKey
     * @param string $typeName
     */
    public function __construct($type, $typeId, $locale, $form, $data = [], $webspaceKey = null, $typeName = '')
    {
        $this->type = $type;
        $this->typeId = $typeId;
        $this->locale = $locale;
        $this->form = $form;
        $this->webspaceKey = $webspaceKey;
        $this->typeName = $typeName;

        foreach ($data as $name => $value) {
            $this->__set($name, $value);
        }
    }

    /**
     * Get data.
     *
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
     * Get field type.
     *
     * @param string $key
     *
     * @return string
     */
    public function getFieldType($key)
    {
        if (!$this->form) {
            return;
        }

        return $this->form->getFieldType($key);
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
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get typeId.
     *
     * @return string
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Get typeName.
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Get webspaceKey.
     *
     * @return string
     */
    public function getWebspaceKey()
    {
        return $this->webspaceKey;
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
     * {@inheritdoc}
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * {@inheritdoc}
     */
    public function getChanger()
    {
        return $this->changer;
    }
}

<?php

/*
 * This file is part of Sulu.
 * (c) Sulu GmbH
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\Entity;

use Sulu\Component\Persistence\Model\AuditableInterface;
use Sulu\Component\Security\Authentication\UserInterface;

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
     * @var null|int
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
     * @var null|Form
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
     * @var null|\DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $changed;

    /**
     * @var UserInterface
     */
    private $creator;

    /**
     * @var UserInterface
     */
    private $changer;

    /**
     * Dynamic constructor.
     *
     * @param mixed[] $data
     */
    public function __construct(string $type, string $typeId, string $locale, ?Form $form, array $data = [], string $webspaceKey = null, string $typeName = '')
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
     * @return mixed[]
     */
    public function getData(): array
    {
        return json_decode($this->data, true);
    }

    /**
     * {@inheritdoc}
     */
    public function __set(string $name, string $value): void
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
    public function __isset(string $name): bool
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
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->getField($name);
    }

    /**
     * @return string|mixed|null
     */
    public function getField(string $key)
    {
        if (property_exists($this, $key)) {
            if (in_array($key, self::$ARRAY_TYPES)) {
                if (!is_string($this->$key)) {
                    return null;
                }

                return json_decode($this->$key, true);
            }

            return $this->$key;
        }

        $array = $this->getData();

        if (isset($array[$key])) {
            return $array[$key];
        }

        return null;
    }

    /**
     * @return mixed[]
     */
    public function getFields(bool $hideHidden = false): array
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
     * @return mixed[]
     */
    public function getFieldsByType(string $type): array
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

    public function getFieldType(string $key): ?string
    {
        if (!$this->form) {
            return null;
        }

        return $this->form->getFieldType($key);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getForm(): Form
    {
        return $this->form;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTypeId(): string
    {
        return $this->typeId;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getWebspaceKey(): string
    {
        return $this->webspaceKey;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    /**
     * {@inheritdoc}
     */
    public function getChanged(): \DateTime
    {
        return $this->changed;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreator(): ?UserInterface
    {
        return $this->creator;
    }

    /**
     * {@inheritdoc}
     */
    public function getChanger(): ?UserInterface
    {
        return $this->changer;
    }
}

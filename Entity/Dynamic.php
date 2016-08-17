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

    /**
     * Set uuid
     *
     * @param string $uuid
     *
     * @return Dynamic
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return Dynamic
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set webspaceKey
     *
     * @param string $webspaceKey
     *
     * @return Dynamic
     */
    public function setWebspaceKey($webspaceKey)
    {
        $this->webspaceKey = $webspaceKey;

        return $this;
    }

    /**
     * Get webspaceKey
     *
     * @return string
     */
    public function getWebspaceKey()
    {
        return $this->webspaceKey;
    }

    /**
     * Set salutation
     *
     * @param string $salutation
     *
     * @return Dynamic
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;

        return $this;
    }

    /**
     * Get salutation
     *
     * @return string
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Dynamic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Dynamic
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Dynamic
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Dynamic
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Dynamic
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Dynamic
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Dynamic
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return Dynamic
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Dynamic
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Dynamic
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Dynamic
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set function
     *
     * @param string $function
     *
     * @return Dynamic
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return Dynamic
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Dynamic
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set textarea
     *
     * @param string $textarea
     *
     * @return Dynamic
     */
    public function setTextarea($textarea)
    {
        $this->textarea = $textarea;

        return $this;
    }

    /**
     * Get textarea
     *
     * @return string
     */
    public function getTextarea()
    {
        return $this->textarea;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Dynamic
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set attachment
     *
     * @param string $attachment
     *
     * @return Dynamic
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set checkbox
     *
     * @param string $checkbox
     *
     * @return Dynamic
     */
    public function setCheckbox($checkbox)
    {
        $this->checkbox = $checkbox;

        return $this;
    }

    /**
     * Get checkbox
     *
     * @return string
     */
    public function getCheckbox()
    {
        return $this->checkbox;
    }

    /**
     * Set checkboxMultiple
     *
     * @param string $checkboxMultiple
     *
     * @return Dynamic
     */
    public function setCheckboxMultiple($checkboxMultiple)
    {
        $this->checkboxMultiple = $checkboxMultiple;

        return $this;
    }

    /**
     * Get checkboxMultiple
     *
     * @return string
     */
    public function getCheckboxMultiple()
    {
        return $this->checkboxMultiple;
    }

    /**
     * Set dropdown
     *
     * @param string $dropdown
     *
     * @return Dynamic
     */
    public function setDropdown($dropdown)
    {
        $this->dropdown = $dropdown;

        return $this;
    }

    /**
     * Get dropdown
     *
     * @return string
     */
    public function getDropdown()
    {
        return $this->dropdown;
    }

    /**
     * Set dropdownMultiple
     *
     * @param string $dropdownMultiple
     *
     * @return Dynamic
     */
    public function setDropdownMultiple($dropdownMultiple)
    {
        $this->dropdownMultiple = $dropdownMultiple;

        return $this;
    }

    /**
     * Get dropdownMultiple
     *
     * @return string
     */
    public function getDropdownMultiple()
    {
        return $this->dropdownMultiple;
    }

    /**
     * Set radioButtons
     *
     * @param string $radioButtons
     *
     * @return Dynamic
     */
    public function setRadioButtons($radioButtons)
    {
        $this->radioButtons = $radioButtons;

        return $this;
    }

    /**
     * Get radioButtons
     *
     * @return string
     */
    public function getRadioButtons()
    {
        return $this->radioButtons;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return Dynamic
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set form
     *
     * @param \L91\Sulu\Bundle\FormBundle\Entity\Form $form
     *
     * @return Dynamic
     */
    public function setForm(\L91\Sulu\Bundle\FormBundle\Entity\Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \L91\Sulu\Bundle\FormBundle\Entity\Form
     */
    public function getForm()
    {
        return $this->form;
    }
}

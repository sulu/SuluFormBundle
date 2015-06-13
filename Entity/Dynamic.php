<?php

namespace L91\Sulu\Bundle\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dynamic
 */
class Dynamic
{
    /**
     * @var string
     */
    private $form;

    /**
     * @var string
     */
    private $data;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var integer
     */
    private $id;

    /**
     * set created time
     */
    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * Set form
     *
     * @param string $form
     * @return Dynamic
     */
    public function setForm($form)
    {
        $this->form = $form;
    
        return $this;
    }

    /**
     * Get form
     *
     * @return string 
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return Dynamic
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Dynamic
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
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
}

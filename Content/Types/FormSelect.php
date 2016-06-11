<?php

namespace L91\Sulu\Bundle\FormBundle\Content\Types;

use Sulu\Component\Content\SimpleContentType;

/**
 * ContentType for selecting a form.
 */
class FormSelect extends SimpleContentType
{
    /**
     * @var string
     */
    private $template;

    public function __construct($template)
    {
        parent::__construct('FormSelect', '');
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }
}

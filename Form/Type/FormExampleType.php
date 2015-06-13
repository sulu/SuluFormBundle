<?php

namespace L91\Sulu\Bundle\FormBundle\Form\Type;

use L91\Sulu\Bundle\FormBundle\Entity\Example;
use Symfony\Component\Form\FormBuilderInterface;

class FormExampleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    protected $dataClass = 'L91\Sulu\Bundle\FormBundle\Entity\Example';

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setData(new Example());

        $builder->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('email', 'text')
            ->add('customOption', 'choice', array(
                'choices' => preg_split('/\r\n|\r|\n/',  $this->getAttribute('options'))
            ))
            ->add('submit', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'l91_form_example';
    }
}

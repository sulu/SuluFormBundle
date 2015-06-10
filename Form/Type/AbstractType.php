<?php

namespace Client\Bundle\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbstractType
 * @package Client\Bundle\FormBundle\Form\Type
 */
abstract class AbstractType extends SymfonyAbstractType implements TypeInterface
{
    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (isset($options['data']) && isset($options['data']['attributes'])) {
            $this->setAttributes($options['data']['attributes']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->getDataClass(),
        ));
    }

    /**
     * @return string
     */
    abstract function getDataClass();

    /**
     * @param $name
     * @param string $parent
     *
     * @return mixed
     */
    protected function getAttribute($name, $parent = 'content')
    {
        if (
            isset($this->attributes[$parent])
            && isset($this->attributes[$parent][$name])
        ) {
            return $this->attributes[$parent][$name];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getSuccessMail()
    {
        return 'ClientWebsiteBundle:views:form/' . $this->getName() . '/success.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getNotifyMail()
    {
        return 'ClientWebsiteBundle:views:form/' . $this->getName() . '/notify.html.twig';
    }

}
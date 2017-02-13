<?php

namespace Sulu\Bundle\FormBundle\Dynamic\Collections;

use Sulu\Bundle\FormBundle\Dynamic\FormCollectionTitleInterface;
use Sulu\Bundle\FormBundle\Dynamic\FormFieldTypeConfiguration;
use Sulu\Bundle\FormBundle\Entity\FormField;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * TODO: add interace
 * TODO: comments
 */
class Page implements FormCollectionTitleInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        dump('getConfiguration');
        exit;
        return new FormFieldTypeConfiguration(
            'sulu_form.type.attachment',
            'SuluFormBundle:forms:fields/types/attachment.html.twig'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        dump('getTitle');
        exit;
    }
}

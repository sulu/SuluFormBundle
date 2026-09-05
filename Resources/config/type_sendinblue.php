<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Sulu\Bundle\FormBundle\Dynamic\Helper\SendinblueListSelect;
use Sulu\Bundle\FormBundle\Dynamic\Helper\SendinblueMailTemplateSelect;
use Sulu\Bundle\FormBundle\Dynamic\Types\SendinblueType;
use Sulu\Bundle\FormBundle\Event\SendinblueListSubscriber;
use Symfony\Component\DependencyInjection\Reference;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.subscriber.sendinblue_list_subscriber', SendinblueListSubscriber::class)
        ->args([
            new Reference('request_stack'),
            '%sulu_form.sendinblue_api_key%',
            null,
            new Reference('sulu_markup.link_tag.provider_pool'),
        ])
        ->tag('kernel.event_subscriber');

    $services->set('sulu_form.dynamic.type_sendinblue', SendinblueType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'sendinblue']);

    $services->set('sulu_form.dynamic.sendinblue_list_select', SendinblueListSelect::class)
        ->public()
        ->args(['%sulu_form.sendinblue_api_key%']);

    $services->set('sulu_form.dynamic.sendinblue_mail_template_select', SendinblueMailTemplateSelect::class)
        ->public()
        ->args(['%sulu_form.sendinblue_api_key%']);
};

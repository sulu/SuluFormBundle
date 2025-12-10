<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.subscriber.sendinblue_list_subscriber', Sulu\Bundle\FormBundle\Event\SendinblueListSubscriber::class)
        ->args([
            service('request_stack'),
            '%sulu_form.sendinblue_api_key%',
            null,
            service('sulu_markup.link_tag.provider_pool'),
        ])
        ->tag('kernel.event_subscriber');

    $services->set('sulu_form.dynamic.type_sendinblue', Sulu\Bundle\FormBundle\Dynamic\Types\SendinblueType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'sendinblue']);

    $services->set('sulu_form.dynamic.sendinblue_list_select', Sulu\Bundle\FormBundle\Dynamic\Helper\SendinblueListSelect::class)
        ->public()
        ->args(['%sulu_form.sendinblue_api_key%']);

    $services->set('sulu_form.dynamic.sendinblue_mail_template_select', Sulu\Bundle\FormBundle\Dynamic\Helper\SendinblueMailTemplateSelect::class)
        ->public()
        ->args(['%sulu_form.sendinblue_api_key%']);
};

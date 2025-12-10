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

return static function(ContainerConfigurator $container) {
    $services = $container->services();
    $parameters = $container->parameters();

    $services->set('sulu_form.subscriber.mailchimp_list_subscriber', Sulu\Bundle\FormBundle\Event\MailchimpListSubscriber::class)
        ->args([
            '%sulu_form.mailchimp_api_key%',
            '%sulu_form.mailchimp_subscribe_status%',
        ])
        ->tag('kernel.event_subscriber');

    $services->set('sulu_form.dynamic.type_mailchimp', Sulu\Bundle\FormBundle\Dynamic\Types\MailchimpType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'mailchimp']);

    $services->set('sulu_form.dynamic.mailchimp_list_select', Sulu\Bundle\FormBundle\Dynamic\Helper\MailchimpListSelect::class)
        ->public()
        ->args(['%sulu_form.mailchimp_api_key%']);
};

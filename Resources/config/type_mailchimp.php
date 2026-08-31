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

use Sulu\Bundle\FormBundle\Dynamic\Helper\MailchimpListSelect;
use Sulu\Bundle\FormBundle\Dynamic\Types\MailchimpType;
use Sulu\Bundle\FormBundle\Event\MailchimpListSubscriber;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.subscriber.mailchimp_list_subscriber', MailchimpListSubscriber::class)
        ->args([
            '%sulu_form.mailchimp_api_key%',
            '%sulu_form.mailchimp_subscribe_status%',
        ])
        ->tag('kernel.event_subscriber');

    $services->set('sulu_form.dynamic.type_mailchimp', MailchimpType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'mailchimp']);

    $services->set('sulu_form.dynamic.mailchimp_list_select', MailchimpListSelect::class)
        ->public()
        ->args(['%sulu_form.mailchimp_api_key%']);
};

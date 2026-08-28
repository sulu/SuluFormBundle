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

use Brevo\Brevo;
use Sulu\Bundle\FormBundle\Controller\SelectApi\BrevoListSelectController;
use Sulu\Bundle\FormBundle\Controller\SelectApi\BrevoMailTemplateSelectController;
use Sulu\Bundle\FormBundle\Dynamic\Types\BrevoType;
use Sulu\Bundle\FormBundle\Event\BrevoListSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.brevo_list_subscriber', BrevoListSubscriber::class)
        ->args([
            new Reference('request_stack'),
            new Reference('sulu_form.brevo_client'),
            new Reference('sulu_markup.link_tag.provider_pool', ContainerInterface::NULL_ON_INVALID_REFERENCE),
        ])
        ->tag('kernel.event_subscriber');

    $services->set('sulu_form.dynamic.type_brevo', BrevoType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'brevo']);

    $services->set('sulu_form.brevo_mail_template_select_controller', BrevoMailTemplateSelectController::class)
        ->public()
        ->args([new Reference('sulu_form.brevo_client')]);

    $services->set('sulu_form.brevo_list_select_controller', BrevoListSelectController::class)
        ->public()
        ->args([new Reference('sulu_form.brevo_client')]);

    $services->set('sulu_form.brevo_client', Brevo::class)
        ->args(['$apiKey' => '%sulu_form.brevo_api_key%']);
};

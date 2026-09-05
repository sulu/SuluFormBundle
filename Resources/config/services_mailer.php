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

use Sulu\Bundle\FormBundle\Mail\MailerHelper;
use Symfony\Component\DependencyInjection\Reference;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu.mail.mailer', MailerHelper::class)
        ->args([
            new Reference('mailer.mailer'),
            '%sulu_form.mail.from%',
            '%sulu_form.mail.to%',
            '%sulu_form.mail.sender%',
            new Reference('logger'),
        ]);
};

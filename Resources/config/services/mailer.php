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
    $parameters = $container->parameters();

    $services->set('sulu.mail.mailer', Sulu\Bundle\FormBundle\Mailer\FormDataMailer::class)
        ->args([
            service('mailer.mailer'),
            '%sulu_form.mail.from%',
            '%sulu_form.mail.to%',
            '%sulu_form.mail.sender%',
            service('logger'),
        ]);

    $services->alias('sulu.mail.helper', 'sulu.mail.mailer');

    $services->alias(Sulu\Bundle\FormBundle\Mailer\FormDataMailerInterface::class, 'sulu.mail.mailer');
};

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

use Sulu\Bundle\FormBundle\Dynamic\Types\RecaptchaType;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.dynamic.type_recaptcha', RecaptchaType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'recaptcha']);
};

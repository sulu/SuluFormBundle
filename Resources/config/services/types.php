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

    $services->set('sulu_form.dynamic.type_text', Sulu\Bundle\FormBundle\Dynamic\Types\TextType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'text']);

    $services->set('sulu_form.dynamic.type_firstname', Sulu\Bundle\FormBundle\Dynamic\Types\FirstNameType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'firstName']);

    $services->set('sulu_form.dynamic.type_lastname', Sulu\Bundle\FormBundle\Dynamic\Types\LastNameType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'lastName']);

    $services->set('sulu_form.dynamic.type_street', Sulu\Bundle\FormBundle\Dynamic\Types\StreetType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'street']);

    $services->set('sulu_form.dynamic.type_zip', Sulu\Bundle\FormBundle\Dynamic\Types\ZipType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'zip']);

    $services->set('sulu_form.dynamic.type_city', Sulu\Bundle\FormBundle\Dynamic\Types\CityType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'city']);

    $services->set('sulu_form.dynamic.type_state', Sulu\Bundle\FormBundle\Dynamic\Types\StateType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'state']);

    $services->set('sulu_form.dynamic.type_function', Sulu\Bundle\FormBundle\Dynamic\Types\FunctionType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'function']);

    $services->set('sulu_form.dynamic.type_company', Sulu\Bundle\FormBundle\Dynamic\Types\CompanyType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'company']);

    $services->set('sulu_form.dynamic.type_phone', Sulu\Bundle\FormBundle\Dynamic\Types\PhoneType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'phone']);

    $services->set('sulu_form.dynamic.type_fax', Sulu\Bundle\FormBundle\Dynamic\Types\FaxType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'fax']);

    $services->set('sulu_form.dynamic.type_title', Sulu\Bundle\FormBundle\Dynamic\Types\TitleType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'title']);

    $services->set('sulu_form.dynamic.type_textarea', Sulu\Bundle\FormBundle\Dynamic\Types\TextareaType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'textarea']);

    $services->set('sulu_form.dynamic.type_headline', Sulu\Bundle\FormBundle\Dynamic\Types\HeadlineType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'headline']);

    $services->set('sulu_form.dynamic.type_spacer', Sulu\Bundle\FormBundle\Dynamic\Types\SpacerType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'spacer']);

    $services->set('sulu_form.dynamic.type_freetext', Sulu\Bundle\FormBundle\Dynamic\Types\FreeTextType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'freeText']);

    $services->set('sulu_form.dynamic.type_country', Sulu\Bundle\FormBundle\Dynamic\Types\CountryType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'country']);

    $services->set('sulu_form.dynamic.type_email', Sulu\Bundle\FormBundle\Dynamic\Types\EmailType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'email']);

    $services->set('sulu_form.dynamic.type_date', Sulu\Bundle\FormBundle\Dynamic\Types\DateType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'date']);

    $services->set('sulu_form.dynamic.type_checkobox', Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'checkbox']);

    $services->set('sulu_form.dynamic.type_checkboxmultiple', Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxMultipleType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'checkboxMultiple']);

    $services->set('sulu_form.dynamic.type_dropdown', Sulu\Bundle\FormBundle\Dynamic\Types\DropdownType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'dropdown']);

    $services->set('sulu_form.dynamic.type_radiobuttons', Sulu\Bundle\FormBundle\Dynamic\Types\RadioButtonsType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'radioButtons']);

    $services->set('sulu_form.dynamic.type_dropdownmultiple', Sulu\Bundle\FormBundle\Dynamic\Types\DropdownMultiple::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'dropdownMultiple']);

    $services->set('sulu_form.dynamic.type_salutation', Sulu\Bundle\FormBundle\Dynamic\Types\SalutationType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'salutation']);

    $services->set('sulu_form.dynamic.type_attachment', Sulu\Bundle\FormBundle\Dynamic\Types\AttachmentType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'attachment']);

    $services->set('sulu_form.dynamic.type_hidden', Sulu\Bundle\FormBundle\Dynamic\Types\HiddenType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'hidden']);
};

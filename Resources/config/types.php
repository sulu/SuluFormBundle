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

use Sulu\Bundle\FormBundle\Dynamic\Types\AttachmentType;
use Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxMultipleType;
use Sulu\Bundle\FormBundle\Dynamic\Types\CheckboxType;
use Sulu\Bundle\FormBundle\Dynamic\Types\CityType;
use Sulu\Bundle\FormBundle\Dynamic\Types\CompanyType;
use Sulu\Bundle\FormBundle\Dynamic\Types\CountryType;
use Sulu\Bundle\FormBundle\Dynamic\Types\DateType;
use Sulu\Bundle\FormBundle\Dynamic\Types\DropdownMultiple;
use Sulu\Bundle\FormBundle\Dynamic\Types\DropdownType;
use Sulu\Bundle\FormBundle\Dynamic\Types\EmailType;
use Sulu\Bundle\FormBundle\Dynamic\Types\FaxType;
use Sulu\Bundle\FormBundle\Dynamic\Types\FirstNameType;
use Sulu\Bundle\FormBundle\Dynamic\Types\FreeTextType;
use Sulu\Bundle\FormBundle\Dynamic\Types\FunctionType;
use Sulu\Bundle\FormBundle\Dynamic\Types\HeadlineType;
use Sulu\Bundle\FormBundle\Dynamic\Types\HiddenType;
use Sulu\Bundle\FormBundle\Dynamic\Types\LastNameType;
use Sulu\Bundle\FormBundle\Dynamic\Types\PhoneType;
use Sulu\Bundle\FormBundle\Dynamic\Types\RadioButtonsType;
use Sulu\Bundle\FormBundle\Dynamic\Types\SalutationType;
use Sulu\Bundle\FormBundle\Dynamic\Types\SpacerType;
use Sulu\Bundle\FormBundle\Dynamic\Types\StateType;
use Sulu\Bundle\FormBundle\Dynamic\Types\StreetType;
use Sulu\Bundle\FormBundle\Dynamic\Types\TextareaType;
use Sulu\Bundle\FormBundle\Dynamic\Types\TextType;
use Sulu\Bundle\FormBundle\Dynamic\Types\TitleType;
use Sulu\Bundle\FormBundle\Dynamic\Types\ZipType;

return static function(ContainerConfigurator $container) {
    $services = $container->services();

    $services->set('sulu_form.dynamic.type_text', TextType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'text']);

    $services->set('sulu_form.dynamic.type_firstname', FirstNameType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'firstName']);

    $services->set('sulu_form.dynamic.type_lastname', LastNameType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'lastName']);

    $services->set('sulu_form.dynamic.type_street', StreetType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'street']);

    $services->set('sulu_form.dynamic.type_zip', ZipType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'zip']);

    $services->set('sulu_form.dynamic.type_city', CityType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'city']);

    $services->set('sulu_form.dynamic.type_state', StateType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'state']);

    $services->set('sulu_form.dynamic.type_function', FunctionType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'function']);

    $services->set('sulu_form.dynamic.type_company', CompanyType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'company']);

    $services->set('sulu_form.dynamic.type_phone', PhoneType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'phone']);

    $services->set('sulu_form.dynamic.type_fax', FaxType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'fax']);

    $services->set('sulu_form.dynamic.type_title', TitleType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'title']);

    $services->set('sulu_form.dynamic.type_textarea', TextareaType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'textarea']);

    $services->set('sulu_form.dynamic.type_headline', HeadlineType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'headline']);

    $services->set('sulu_form.dynamic.type_spacer', SpacerType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'spacer']);

    $services->set('sulu_form.dynamic.type_freetext', FreeTextType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'freeText']);

    $services->set('sulu_form.dynamic.type_country', CountryType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'country']);

    $services->set('sulu_form.dynamic.type_email', EmailType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'email']);

    $services->set('sulu_form.dynamic.type_date', DateType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'date']);

    $services->set('sulu_form.dynamic.type_checkobox', CheckboxType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'checkbox']);

    $services->set('sulu_form.dynamic.type_checkboxmultiple', CheckboxMultipleType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'checkboxMultiple']);

    $services->set('sulu_form.dynamic.type_dropdown', DropdownType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'dropdown']);

    $services->set('sulu_form.dynamic.type_radiobuttons', RadioButtonsType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'radioButtons']);

    $services->set('sulu_form.dynamic.type_dropdownmultiple', DropdownMultiple::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'dropdownMultiple']);

    $services->set('sulu_form.dynamic.type_salutation', SalutationType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'salutation']);

    $services->set('sulu_form.dynamic.type_attachment', AttachmentType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'attachment']);

    $services->set('sulu_form.dynamic.type_hidden', HiddenType::class)
        ->tag('sulu_form.dynamic.type', ['alias' => 'hidden']);
};

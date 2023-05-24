<?php

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\FormBundle\ListBuilder;

use Sulu\Bundle\FormBundle\Entity\Dynamic;
use Sulu\Bundle\FormBundle\Entity\Form;

class DynamicLabeledListBuilder extends DynamicListBuilder
{
    private $formFieldsLabelCache = [];

    public function build(Dynamic $dynamic, string $locale): array
    {
        $entry = parent::build($dynamic, $locale);

        if (empty($entry)) {
            return $entry;
        }

        $labels = $this->getLabels($dynamic->getForm(), $locale);
        $entryLabeled = [];

        foreach ($entry[0] as $key => $value) {
            $entryLabeled[$labels[$key] ?? $key] = $value;
        }

        return [$entryLabeled];
    }

    private function getLabels(Form $form, string $locale): array
    {
        if (!isset($this->formFieldsLabelCache[$form->getId()])) {
            $labels = [];

            foreach ($form->getFields() as $field) {
                $label = '';
                $translation = $field->getTranslation($locale, false, true);

                if ($translation) {
                    $label = $translation->getShortTitle() ?: \strip_tags($translation->getTitle());
                }

                $labels[$field->getKey()] = $label;
            }

            $this->formFieldsLabelCache[$form->getId()] = $labels;
        }

        return $this->formFieldsLabelCache[$form->getId()];
    }
}
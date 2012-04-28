<?php

require_once(t3lib_extMgm::extPath('t3chimp') . '/Lib/HtmlTag.class.php');

class Tx_T3chimp_ViewHelpers_MailchimpFormViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
    private function hasErrors($fieldDefinition) {
        return $fieldDefinition['errors'] !== NULL && count($fieldDefinition['errors']) > 0;
    }

    /**
     * @param array $fieldDefinitions
     * @param array $interestGroupings
     * @return string
     */
    public function render($fieldDefinitions, $interestGroupings = array()) {
        usort($fieldDefinition, array($this, 'sortFields'));
        usort($interestGroupings, array($this, 'sortGroupings'));
        $content = '<div class="mc-fields">';

        foreach($fieldDefinitions as $fieldDefinition) {
            switch($fieldDefinition['field_type']) {
                case 'dropdown':
                    $content .= $this->renderDropdownField($fieldDefinition);
                break;

                case 'radio':
                    $content .= $this->renderRadioField($fieldDefinition);
                break;

                case 'email':
                case 'text':
                    $content .= $this->renderTextField($fieldDefinition);
                break;
            }
        }

        $content .= '</div>';

        foreach($interestGroupings as $grouping) {
            $content .= '<div class="mc-groups">' . $this->renderInterestGrouping($grouping) . '</div>';
        }

        return $content;
    }

    public function renderDropdownField($fieldDefinition) {
        $value = $fieldDefinition['value'] != NULL ? $fieldDefinition['value'] : $fieldDefinition['default'];
        $select = new HtmlTag('select');
        $select->setAttribute('name', $fieldDefinition['tag']);
        $select->setAttribute('id', $fieldDefinition['tag']);

        foreach($fieldDefinition['choices'] as $choice) {
            $option = new HtmlTag('option');
            $option->setAttribute('value', $choice);
            $option->addContent($choice);
            if($choice == $value) {
                $option->setAttribute('selected', 'selected');
            }
            $select->addContent($option);
        }

        $section = new HtmlTag('p');
        $section->setAttribute('class', 'mc-field, mc-field-' . strtolower($fieldDefinition['tag']));
        $section->addContent($this->renderLabel($fieldDefinition['name'], $fieldDefinition['tag'], $fieldDefinition['req']));
        $section->addContent('<br />');
        $section->addContent($select);

        if($this->hasErrors($fieldDefinition)) {
            $section->addContent('<br />');
            $section->addContent($this->renderErrors($fieldDefinition));
            $section->setAttribute('class', 'invalid');
        }

        return $section;
    }

    private function renderErrors($fieldDefinition) {
        $container = new HtmlTag('span');
        $container->setAttribute('class', 'errors');

        foreach($fieldDefinition['errors'] as $error) {
            $container->addContent($error);
            $container->addContent('<br />');
        }

        return $container;
    }

    public function renderInterestGrouping($grouping) {
        $choices = $grouping['groups'];
        usort($groups, array($choices, 'sortGroupings'));
        $selection = (is_array($grouping['selection'])) ? $grouping['selection'] : array();

        $group = new HtmlTag('p');
        $group->setAttribute('class', 'mc-group mc-group-' . $grouping['id']);
        $group->addContent('<span class="caption">' . $grouping['name'] . '</span>');

        foreach($choices as $choice) {
            $id = 'mc_group_' . $grouping['id'] . '_' . $choice['bit'];
            $container = new HtmlTag('span');
            $container->setAttribute('id', $id . '_container');

            $checkbox = new HtmlTag('input', true);
            $checkbox->setAttribute('type', 'checkbox');
            $checkbox->setAttribute('name', $id);
            $checkbox->setAttribute('id', $id);
            $checkbox->setAttribute('checked', "checked");
            $checkbox->setAttribute('value', $choice['bit']);
            if(in_array($choice['bit'], $selection)) {
                $checkbox->setAttribute('checked', 'checked');
            }
            $container->addContent($checkbox);
            $container->addContent($this->renderLabel($choice['name'], $id, false));
            $group->addContent($container);
        }

        return $group;
    }

    public function renderLabel($text, $target, $required) {
        $label = new HtmlTag('label');
        $label->setAttribute('for', $target);
        $label->addContent($text);
        if($required) {
            $label->addContent(' *');
        }
        return $label;
    }

    public function renderRadioField($fieldDefinition) {
        $value = $fieldDefinition['value'] != NULL ? $fieldDefinition['value'] : $fieldDefinition['default'];
        if($value == '') $value = $fieldDefinition['choices'][0];

        $radioGroup = new HtmlTag('p');
        $radioGroup->setAttribute('class', 'mc-field, mc-field-' . strtolower($fieldDefinition['tag']));
        $radioGroup->addContent('<span class="radio-caption">' . $fieldDefinition['name'] . '</span><br />');

        foreach($fieldDefinition['choices'] as $choice) {
            $id = $fieldDefinition['tag'] . '_' . $choice;
            $radio = new HtmlTag('input', true);
            $radio->setAttribute('type', 'radio');
            $radio->setAttribute('name', $fieldDefinition['tag']);
            $radio->setAttribute('id', $id);
            $radio->setAttribute('value', $choice);
            if($choice == $value) {
                $radio->setAttribute('checked', 'checked');
            }
            $radioGroup->addContent($radio);
            $radioGroup->addContent($this->renderLabel($choice, $id, false));
        }

        return $radioGroup;
    }

    public function renderTextField($fieldDefinition) {
        $value = $fieldDefinition['value'] != NULL ? $fieldDefinition['value'] : $fieldDefinition['default'];
        $input = new HtmlTag('input', true);
        $input->setAttribute('name', $fieldDefinition['tag']);
        $input->setAttribute('id', $fieldDefinition['tag']);
        if($fieldDefinition['req']) {
            $input->setAttribute('required', 'required');
        }
        $input->setAttribute('type', $fieldDefinition['field_type']);
        $input->setAttribute('value', $value);

        $section = new HtmlTag('p');
        $section->setAttribute('class', 'mc-field, mc-field-' . strtolower($fieldDefinition['tag']));
        $section->addContent($this->renderLabel($fieldDefinition['name'], $fieldDefinition['tag'], $fieldDefinition['req']));
        $section->addContent('<br />');
        $section->addContent($input);

        if($this->hasErrors($fieldDefinition)) {
            $section->addContent('<br />');
            $section->addContent($this->renderErrors($fieldDefinition));
            $section->setAttribute('class', 'invalid');
        }

        return $section;
    }

    public function sortFields($a, $b) {
        if ($a['order'] == $b['order']) {
            return 0;
        }

        return ($a['order'] < $b['order']) ? -1 : 1;
    }

    public function sortGroupings($a, $b) {
        if ($a['display_order'] == $b['display_order']) {
            return 0;
        }

        return ($a['display_order'] < $b['display_order']) ? -1 : 1;
    }
}

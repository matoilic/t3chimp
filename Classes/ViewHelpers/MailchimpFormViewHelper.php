<?php

require_once(t3lib_extMgm::extPath('t3chimp') . '/Lib/HtmlTag.class.php');

class Tx_T3chimp_ViewHelpers_MailchimpFormViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
    private function hasErrors($fieldDefinition) {
        return $fieldDefinition['errors'] !== NULL && count($fieldDefinition['errors']) > 0;
    }

    /**
     * @param array $fieldDefinitions
     * @return string
     */
    public function render($fieldDefinitions) {
        usort($fieldDefinition, array($this, 'sort'));
        $content = '';

        foreach($fieldDefinitions as $fieldDefinition) {
            switch($fieldDefinition['field_type']) {
                case 'dropdown':
                    $content .= $this->renderDropdownField($fieldDefinition);
                break;

                case 'email':
                    $content .= $this->renderTextField($fieldDefinition);
                break;

                case 'radio':
                    $content .= $this->renderRadioField($fieldDefinition);
                break;

                case 'text':
                    $content .= $this->renderTextField($fieldDefinition);
                break;
            }
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
        $radioGroup->addContent($fieldDefinition['name'] . '<br />');

        foreach($fieldDefinition['choices'] as $choice) {
            $id = $fieldDefinition['name'] . '_' . $choice;
            $radio = new HtmlTag('input', true);
            $radio->setAttribute('type', 'radio');
            $radio->setAttribute('name', $fieldDefinition['name']);
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

    public function sort($a, $b) {
        if ($a['order'] == $b['order']) {
            return 0;
        }

        return ($a['order'] < $b['order']) ? -1 : 1;
    }
}

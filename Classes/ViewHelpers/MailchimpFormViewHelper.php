<?php

require_once(t3lib_extMgm::extPath('t3chimp') . '/Lib/HtmlTag.class.php');

class Tx_T3chimp_ViewHelpers_MailchimpFormViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
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

                case 'text':
                    $content .= $this->renderTextField($fieldDefinition);
                break;
            }
        }

        return $content;
    }

    public function renderDropdownField($fieldDefinition) {
        $select = new HtmlTag('select');
        $select->setAttribute('name', $fieldDefinition['tag']);
        $select->setAttribute('id', $fieldDefinition['tag']);

        foreach($fieldDefinition['choices'] as $choice) {
            $option = new HtmlTag('option');
            $option->setAttribute('value', $choice);
            $option->addContent($choice);
            if($choice == $fieldDefinition['default']) {
                $option->setAttribute('selected', 'selected');
            }
            $select->addContent($option);
        }

        $section = new HtmlTag('p');
        $section->addContent($this->renderLabel($fieldDefinition['name'], $fieldDefinition['tag']));
        $section->addContent('<br />');
        $section->addContent($select);

        return $section;
    }

    public function renderLabel($text, $target) {
        $label = new HtmlTag('label');
        $label->setAttribute('for', $target);
        $label->addContent($text);
        return $label;
    }

    public function renderTextField($fieldDefinition) {
        $input = new HtmlTag('input', true);
        $input->setAttribute('name', $fieldDefinition['tag']);
        $input->setAttribute('id', $fieldDefinition['tag']);
        if($fieldDefinition['req']) {
            $input->setAttribute('required', 'required');
        }
        $input->setAttribute('type', $fieldDefinition['field_type']);
        $input->setAttribute('value', $fieldDefinition['default']);

        $section = new HtmlTag('p');
        $section->addContent($this->renderLabel($fieldDefinition['name'], $fieldDefinition['tag']));
        $section->addContent('<br />');
        $section->addContent($input);

        return $section;
    }

    public function sort($a, $b) {
        if ($a['order'] == $b['order']) {
            return 0;
        }

        return ($a['order'] < $b['order']) ? -1 : 1;
    }
}

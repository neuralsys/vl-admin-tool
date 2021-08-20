<?php

namespace Vuongdq\VLAdminTool\Utils;

use Vuongdq\VLAdminTool\Common\GeneratorField;

class HTMLFieldGenerator
{
    public static function generateHTML(GeneratorField $field, $templateType)
    {
        $fieldTemplate = '';

        switch ($field->htmlType) {
            case 'text':
            case 'textarea':
            case 'date':
            case 'file':
            case 'email':
            case 'password':
            case 'number':
                $fieldTemplate = get_template('fields.'.$field->htmlType, $templateType);
                break;
            case 'select':
            case 'enum':
                $fieldTemplate = get_template('fields.select', $templateType);
                break;
            case 'checkbox':
                $fieldTemplate = get_template('fields.checkbox', $templateType);
                if (count($field->htmlValues) > 0) {
                    $checkboxValue = $field->htmlValues[0];
                } else {
                    $checkboxValue = 1;
                }
                $fieldTemplate = str_replace('$CHECKBOX_VALUE$', $checkboxValue, $fieldTemplate);
                break;
            case 'radio':
                $fieldTemplate = get_template('fields.radio_group', $templateType);
                $radioTemplate = get_template('fields.radio', $templateType);
                break;
            case 'toggle-switch':
                $fieldTemplate = get_template('fields.toggle-switch', $templateType);
                break;
        }

        return $fieldTemplate;
    }
}

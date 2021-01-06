<?php

namespace Vuongdq\VLAdminTool\Generators\Scaffold;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Generators\BaseGenerator;
use Vuongdq\VLAdminTool\Generators\ViewServiceProviderGenerator;
use Vuongdq\VLAdminTool\Utils\FileUtil;
use Vuongdq\VLAdminTool\Utils\HTMLFieldGenerator;

class ViewGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $templateType;

    /** @var array */
    private $htmlFields;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathViews;
        $this->templateType = config('vl_admin_tool.templates', 'adminlte-templates');
    }

    public function generate()
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }

        $htmlInputs = Arr::pluck($this->commandData->fields, 'htmlInput');
        if (in_array('file', $htmlInputs)) {
            $this->commandData->addDynamicVariable('$FILES$', ", 'files' => true");
        }

        $this->commandData->commandComment("\nGenerating Views...");

        if ($this->commandData->getOption('views')) {
            $viewsToBeGenerated = explode(',', $this->commandData->getOption('views'));

            if (in_array('index', $viewsToBeGenerated)) {
                $this->generateTable();
                $this->generateTableTypes();
                $this->generateIndex();
            }

            if (count(array_intersect(['create', 'update'], $viewsToBeGenerated)) > 0) {
                $this->generateFields();
            }

            if (in_array('create', $viewsToBeGenerated)) {
                $this->generateCreate();
            }

            if (in_array('edit', $viewsToBeGenerated)) {
                $this->generateUpdate();
            }

//            if (in_array('show', $viewsToBeGenerated)) {
//                $this->generateShowFields();
//                $this->generateShow();
//            }
        } else {
            $this->generateTable();
            $this->generateTableTypes();
            $this->generateIndex();
            $this->generateFields();
            $this->generateCreate();
            $this->generateUpdate();
//            $this->generateShowFields();
//            $this->generateShow();
        }

        $this->commandData->commandComment('Views created: ');
    }

    private function generateTable()
    {
        $this->generateDataTableToolbar();
        $templateData = $this->generateDataTableBody();
        $this->generateDataTableActions();

        FileUtil::createFile($this->path, 'table.blade.php', $templateData);

        $this->commandData->commandInfo('table.blade.php created');
    }

    private function generateDataTableToolbar() {
        $templateData = get_template('scaffold.views.toolbar', $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, 'toolbar.blade.php', $templateData);

        $this->commandData->commandInfo('toolbar.blade.php created');

        // js file
        $templateData = get_template('scaffold.views.toolbar_js', $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, 'toolbar_js.blade.php', $templateData);

        $this->commandData->commandInfo('toolbar_js.blade.php created');
    }

    private function generateTableTypes() {
        $templateData = get_template('scaffold.views.table_with_crud_modals', $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, 'table_with_crud_modals.blade.php', $templateData);

        $this->commandData->commandInfo('table_with_crud_modals.blade.php created');

        // only view
        $templateData = get_template('scaffold.views.table_only_view', $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, 'table_only_view.blade.php', $templateData);

        $this->commandData->commandInfo('table_only_view.blade.php created');
    }

    private function generateDataTableBody()
    {
        $templateData = get_template('scaffold.views.datatable_body', $this->templateType);

        return fill_template($this->commandData->dynamicVars, $templateData);
    }

    private function generateDataTableActions()
    {
        $templateName = 'datatables_actions';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, 'datatables_actions.blade.php', $templateData);

        $this->commandData->commandInfo('datatables_actions.blade.php created');
    }

    private function generateBladeTableBody()
    {
        $templateName = 'blade_table_body';

        if ($this->commandData->isLocalizedTemplates()) {
            $templateName .= '_locale';
        }

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace('$FIELD_HEADERS$', $this->generateTableHeaderFields(), $templateData);

        $cellFieldTemplate = get_template('scaffold.views.table_cell', $this->templateType);

        $tableBodyFields = [];

        foreach ($this->commandData->fields as $field) {
            if (!$field->inIndex) {
                continue;
            }

            $tableBodyFields[] = fill_template_with_field_data(
                $this->commandData->dynamicVars,
                $this->commandData->fieldNamesMapping,
                $cellFieldTemplate,
                $field
            );
        }

        $tableBodyFields = implode(infy_nl_tab(1, 3), $tableBodyFields);

        return str_replace('$FIELD_BODY$', $tableBodyFields, $templateData);
    }

    private function generateTableHeaderFields()
    {
        $templateName = 'table_header';

        $localized = false;
        if ($this->commandData->isLocalizedTemplates()) {
            $templateName .= '_locale';
            $localized = true;
        }

        $headerFieldTemplate = get_template('scaffold.views.'.$templateName, $this->templateType);

        $headerFields = [];

        foreach ($this->commandData->fields as $field) {
            if (!$field->inIndex) {
                continue;
            }

            if ($localized) {
                $headerFields[] = $fieldTemplate = fill_template_with_field_data_locale(
                    $this->commandData->dynamicVars,
                    $this->commandData->fieldNamesMapping,
                    $headerFieldTemplate,
                    $field
                );
            } else {
                $headerFields[] = $fieldTemplate = fill_template_with_field_data(
                    $this->commandData->dynamicVars,
                    $this->commandData->fieldNamesMapping,
                    $headerFieldTemplate,
                    $field
                );
            }
        }

        return implode(infy_nl_tab(1, 2), $headerFields);
    }

    private function generateIndex()
    {
        $templateName = 'index';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace('$PAGINATE$', '', $templateData);

        FileUtil::createFile($this->path, 'index.blade.php', $templateData);

        $this->commandData->commandInfo('index.blade.php created');
    }

    private function generateFields()
    {
        $templateName = 'fields';

        $localized = true;

        $this->htmlFields = [];

        foreach ($this->commandData->fields as $field) {
            if (!$field->inForm) {
                continue;
            }

            $validations = explode('|', $field->validations);
            $minMaxRules = '';
            foreach ($validations as $validation) {
                if (!Str::contains($validation, ['max:', 'min:'])) {
                    continue;
                }

                $validationText = substr($validation, 0, 3);
                $sizeInNumber = substr($validation, 4);

                $sizeText = ($validationText == 'min') ? 'minlength' : 'maxlength';
                if ($field->htmlType == 'number') {
                    $sizeText = $validationText;
                }

                $size = ",'$sizeText' => $sizeInNumber";
                $minMaxRules .= $size;
            }
            $this->commandData->addDynamicVariable('$SIZE$', $minMaxRules);

            $fieldTemplate = HTMLFieldGenerator::generateHTML($field, $this->templateType, $localized);

            if ($field->htmlType == 'selectTable') {
                $inputArr = explode(',', $field->htmlValues[1]);
                $columns = '';
                foreach ($inputArr as $item) {
                    $columns .= "'$item'".',';  //e.g 'email,id,'
                }
                $columns = substr_replace($columns, '', -1); // remove last ,

                $htmlValues = explode(',', $field->htmlValues[0]);
                $selectTable = $htmlValues[0];
                $modalName = null;
                if (count($htmlValues) == 2) {
                    $modalName = $htmlValues[1];
                }

                $tableName = $this->commandData->config->tableName;
                $viewPath = $this->commandData->config->prefixes['view'];
                if (!empty($viewPath)) {
                    $tableName = $viewPath.'.'.$tableName;
                }

                $variableName = Str::singular($selectTable).'Items'; // e.g $userItems

                $fieldTemplate = $this->generateViewComposer($tableName, $variableName, $columns, $selectTable, $modalName);
            }

            if (!empty($fieldTemplate)) {
                $fieldTemplate = fill_template_with_field_data(
                    $this->commandData->dynamicVars,
                    $this->commandData->fieldNamesMapping,
                    $fieldTemplate,
                    $field
                );
                $this->htmlFields[] = $fieldTemplate;
            }
        }

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace('$FIELDS$', implode("\n\n", $this->htmlFields), $templateData);

        FileUtil::createFile($this->path, 'fields.blade.php', $templateData);
        $this->commandData->commandInfo('field.blade.php created');
    }

    private function generateViewComposer($tableName, $variableName, $columns, $selectTable, $modelName = null)
    {
        $templateName = 'scaffold.fields.select';
        $fieldTemplate = get_template($templateName, $this->templateType);

        $viewServiceProvider = new ViewServiceProviderGenerator($this->commandData);
        $viewServiceProvider->generate();
        $viewServiceProvider->addViewVariables($tableName.'.fields', $variableName, $columns, $selectTable, $modelName);

        $fieldTemplate = str_replace(
            '$INPUT_ARR$',
            '$'.$variableName,
            $fieldTemplate
        );

        return $fieldTemplate;
    }

    private function generateCreate()
    {
        $templateName = 'create_modal';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, 'create_modal.blade.php', $templateData);
        $this->commandData->commandInfo('create_modal.blade.php created');
    }

    private function generateUpdate()
    {
        $templateName = 'edit_modal';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, 'edit_modal.blade.php', $templateData);
        $this->commandData->commandInfo('edit_modal.blade.php created');
    }

    private function generateShowFields()
    {
        $templateName = 'show_field';
        $fieldTemplate = get_template('scaffold.views.'.$templateName, $this->templateType);

        $fieldsStr = '';

        foreach ($this->commandData->fields as $field) {
            if (!$field->inView) {
                continue;
            }
            $singleFieldStr = str_replace(
                '$FIELD_NAME_TITLE$',
                Str::title(str_replace('_', ' ', $field->name)),
                $fieldTemplate
            );
            $singleFieldStr = str_replace('$FIELD_NAME$', $field->name, $singleFieldStr);
            $singleFieldStr = fill_template($this->commandData->dynamicVars, $singleFieldStr);

            $fieldsStr .= $singleFieldStr."\n\n";
        }

        FileUtil::createFile($this->path, 'show_fields.blade.php', $fieldsStr);
        $this->commandData->commandInfo('show_fields.blade.php created');
    }

    private function generateShow()
    {
        $templateName = 'show';

        $templateData = get_template('scaffold.views.'.$templateName, $this->templateType);

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, 'show.blade.php', $templateData);
        $this->commandData->commandInfo('show.blade.php created');
    }

    public function rollback($views = [])
    {
        $files = [
            'table.blade.php',
            'index.blade.php',
            'fields.blade.php',
            'create.blade.php',
            'edit.blade.php',
            'show.blade.php',
            'show_fields.blade.php',
        ];

        if (!empty($views)) {
            $files = [];
            foreach ($views as $view) {
                $files[] = $view.'.blade.php';
            }
        }

        if ($this->commandData->getAddOn('datatables')) {
            $files[] = 'datatables_actions.blade.php';
        }

        foreach ($files as $file) {
            if ($this->rollbackFile($this->path, $file)) {
                $this->commandData->commandComment($file.' file deleted');
            }
        }
    }
}

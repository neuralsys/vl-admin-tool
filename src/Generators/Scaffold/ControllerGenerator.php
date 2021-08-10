<?php

namespace Vuongdq\VLAdminTool\Generators\Scaffold;

use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Generators\BaseGenerator;
use Vuongdq\VLAdminTool\Utils\FileUtil;

class ControllerGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $templateType;

    /** @var string */
    private $fileName;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathController;
        $this->templateType = config('vl_admin_tool.templates', 'adminlte-templates');
        $this->fileName = $this->commandData->modelName.'Controller.php';
    }

    public function generate()
    {
        $templateName = 'datatable_controller';
        $templateData = get_template("scaffold.controller.$templateName", 'vl-admin-tool');

        $this->generateDataTable();

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandComment("\nControllers created: ");
        $this->commandData->commandInfo($this->fileName);
    }

    private function generateDataTable()
    {
        $templateName = 'datatable';

        $templateData = get_template('scaffold.'.$templateName, 'vl-admin-tool');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace(
            '$DATATABLE_COLUMNS$',
            implode(','.infy_nl_tab(1, 3), $this->generateDataTableColumns(3)),
            $templateData
        );

        $path = $this->commandData->config->pathDataTables;

        $fileName = $this->commandData->modelName.'DataTable.php';

        FileUtil::createFile($path, $fileName, $templateData);

        $this->commandData->commandComment("\nDataTable created: ");
        $this->commandData->commandInfo($fileName);
    }

    private function generateDataTableColumns(int $tabs)
    {
        $templateName = 'datatable_column';
        $headerFieldTemplate = get_template('views.'.$templateName, $this->templateType);
        $headerFieldTemplate = trim($headerFieldTemplate, "\n");
        $dataTableColumns = [];
        foreach ($this->commandData->fields as $field) {
            if (!$field->isShowable) continue;
            $fieldColumn = str_replace('$SEARCHABLE$', $field->isSearchable ? "true" : "false", $headerFieldTemplate);
            $fieldColumn = str_replace('$ORDERABLE$', $field->isOrderable ? "true" : "false", $fieldColumn);
            $fieldColumn = str_replace('$EXPORTABLE$', $field->isExportable ? "true" : "false", $fieldColumn);
            $fieldColumn = str_replace('$PRINTABLE$', $field->isPrintable ? "true" : "false", $fieldColumn);
            $fieldColumn = str_replace('$CSS_CLASS$', $field->cssClasses, $fieldColumn);
            $fieldColumn = str_replace('$TABS$', infy_tabs($tabs), $fieldColumn);

            $fieldTemplate = fill_template_with_field_data(
                $this->commandData->dynamicVars,
                $this->commandData->fieldNamesMapping,
                $fieldColumn,
                $field
            );

            $dataTableColumns[] = $fieldTemplate;
        }

        return $dataTableColumns;
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('Controllers file deleted: '.$this->fileName);
        }

        if ($this->rollbackFile(
            $this->commandData->config->pathDataTables,
            $this->commandData->modelName.'DataTable.php'
        )) {
            $this->commandData->commandComment('DataTable file deleted: '.$this->fileName);
        }
    }
}

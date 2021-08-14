<?php

namespace Vuongdq\VLAdminTool\Generators;

use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Utils\FileUtil;

class DataTableGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $templateType;

    /**
     * ModelGenerator constructor.
     *
     * @param CommandData $commandData
     */
    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->templateType = config('vl_admin_tool.templates', 'adminlte-templates');
    }

    public function generate()
    {
        $templateName = 'datatable';

        $templateData = get_template('scaffold.'.$templateName, 'vl-admin-tool');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace(
            '$DATATABLE_COLUMNS$',
            implode(','.infy_nl_tab(1, 3), $this->generateDataTableColumns()),
            $templateData
        );

        $path = $this->commandData->config->pathDataTables;

        $fileName = $this->commandData->modelName.'DataTable.php';

        FileUtil::createFile($path, $fileName, $templateData);

        $this->commandData->commandComment("\nDataTable created: ");
        $this->commandData->commandInfo($fileName);
    }

    private function generateDataTableColumns(): array
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
            $fieldColumn = str_replace('$TABS$', infy_tabs(3), $fieldColumn);

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
        if ($this->rollbackFile(
            $this->commandData->config->pathDataTables,
            $this->commandData->modelName.'DataTable.php'
        )) {
            $this->commandData->commandComment('DataTable file deleted: '.$this->fileName);
        }
    }
}

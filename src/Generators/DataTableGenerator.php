<?php

namespace Vuongdq\VLAdminTool\Generators;

use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Models\Field;
use Vuongdq\VLAdminTool\Models\Model;
use Vuongdq\VLAdminTool\Utils\FileUtil;
use Vuongdq\VLAdminTool\Common\GeneratorField;

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
        $templateName = 'datatable.main';

        $templateData = get_template('scaffold.'.$templateName, 'vl-admin-tool');

        # common vars
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        # special vars
        $templateData = fill_template($this->generateSpecialVars(), $templateData);

        $path = $this->commandData->config->pathDataTables;

        $fileName = $this->commandData->modelName.'DataTable.php';

        FileUtil::createFile($path, $fileName, $templateData);

        $this->commandData->commandComment("\nDataTable created: ");
        $this->commandData->commandInfo($fileName);
    }

    private function generateSpecialVars() {
        return [
            '$DATATABLE_COLUMNS$' => implode(','.infy_nl_tab(1, 3), $this->generateDataTableColumns()),
            '$SELECTED_COLUMNS$' => $this->generateSelectedColumns(),
            '$FK_QUERIES$' => prefix_tabs_each_line($this->generateFKQueries(), 3),
            '$FK_FILTERS$' => prefix_tabs_each_line($this->generateFKFilters(), 3),
        ];
    }

    private function generateFKQueries() {
        $queries = [];
        /** @var GeneratorField $field */
        foreach ($this->commandData->fields as $field) {
            if ($field->isShowable) {
                if ($field->isForeignKey) {
                    $queries[] = $this->generateFKJoinQuery($field);
                }
            }
        }

        if (count($queries) == 0) return "";
        return "\n" . implode("\n", $queries);
    }

    private function generateFKFilters() {
            $queries = [];
            /** @var GeneratorField $field */
            foreach ($this->commandData->fields as $field) {
                if ($field->isShowable) {
                    if ($field->isForeignKey) {
                        $queries[] = $this->generateFKFilter($field);
                    }
                }
            }

            if (count($queries) == 0) return "";
            return "\n" . implode("\n", $queries);
        }

    private function generateFKJoinQuery(GeneratorField $field) {
        $templateData = get_template('scaffold.datatable.fk_join', 'vl-admin-tool');
        $vars = $this->commandData->generateFKVars($field);
        return trim(fill_template($vars, $templateData));
    }

    private function generateFKFilter(GeneratorField $field) {
        $templateData = get_template('scaffold.datatable.fk_filter', 'vl-admin-tool');
        $vars = $this->commandData->generateFKVars($field);
        return trim(fill_template($vars, $templateData));
    }

    private function generateSelectedColumns() {
        $selectedColumns = [];

        /** @var GeneratorField $field */
        foreach ($this->commandData->fields as $field) {
            if ($field->isShowable) {
                $selectedColumns[] = "'{$field->name}'";
            }
        }

        return implode(",", $selectedColumns);
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

            if ($field->isForeignKey) {
                $vars = $this->commandData->generateFKVars($field);

                $fieldColumn = str_replace(
                    '$FIELD_NAME$',
                    "_". $vars['$SOURCE_TABLE_NAME_SINGULAR_CAMEL$']. "_" . $vars['$SOURCE_SELECTED_COLUMN$'],
                    $fieldColumn
                );

                $fieldColumn = str_replace(
                    '$MODEL_NAME_CAMEL$',
                    $vars['$SOURCE_TABLE_NAME_SINGULAR_CAMEL$'],
                    $fieldColumn
                );

                $fieldColumn = str_replace(
                    '$LANG_FIELD_NAME$',
                    $vars['$SOURCE_SELECTED_COLUMN$'],
                    $fieldColumn
                );
            }

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
            $this->commandData->commandComment('DataTable file deleted: '.$this->commandData->modelName.'DataTable.php');
        }
    }
}

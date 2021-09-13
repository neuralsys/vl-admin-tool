<?php

namespace Vuongdq\VLAdminTool\Generators\Scaffold;

use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Common\GeneratorField;
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

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = fill_template($this->generateSpecialVars(), $templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandComment("\nControllers created: ");
        $this->commandData->commandInfo($this->fileName);
    }

    private function generateSpecialVars() {
        return [
            '$FK_REPO_IMPORT$' => $this->generateFKImports(),
            '$FK_REPO_DECLARATIONS$' => prefix_tabs_each_line($this->generateFKDeclarations(), 1),
            '$FK_REPO_PARAMS$' => prefix_tabs_each_line($this->generateFKParams(), 2),
            '$FK_REPO_ASSIGN$' => prefix_tabs_each_line($this->generateFKAssignments(), 2),
            '$FK_OPTIONS$' => prefix_tabs_each_line($this->generateFKOptions(), 2),
            '$FK_DATA$' => prefix_tabs_each_line($this->generateFKData(), 4),
        ];
    }

    private function generateFKData() {
        $datas = [];

        /** @var GeneratorField $field */
        foreach ($this->commandData->fields as $field) {
            if ($field->isForeignKey) {
                $templateName = 'fk_data';
                $templateData = get_template("scaffold.controller.$templateName", 'vl-admin-tool');
                $templateData = fill_template($this->commandData->dynamicVars, $templateData);
                $datas[] = trim(fill_template($this->commandData->generateFKVars($field), $templateData));
            }
        }

        if (count($datas) == 0) return "";

        return implode("\n", array_unique($datas));
    }

    private function generateFKOptions() {
        $options = [];

        /** @var GeneratorField $field */
        foreach ($this->commandData->fields as $field) {
            if ($field->isForeignKey) {
                $templateName = 'fk_option';
                $templateData = get_template("scaffold.controller.$templateName", 'vl-admin-tool');
                $templateData = fill_template($this->commandData->dynamicVars, $templateData);
                $options[] = trim(fill_template($this->commandData->generateFKVars($field), $templateData));
            }
        }

        if (count($options) == 0) return "";

        return implode("\n", array_unique($options));
    }

    private function generateFKImports() {
        $imports = [];

        /** @var GeneratorField $field */
        foreach ($this->commandData->fields as $field) {
            if ($field->isForeignKey) {
                $templateName = 'fk_repo_import';
                $templateData = get_template("scaffold.controller.$templateName", 'vl-admin-tool');
                $templateData = fill_template($this->commandData->dynamicVars, $templateData);
                $imports[] = trim(fill_template($this->commandData->generateFKVars($field), $templateData));
            }
        }

        if (count($imports) == 0) return "";

        return "\n" . implode("\n", array_unique($imports));
    }

    private function generateFKParams() {
        $params = [];

        /** @var GeneratorField $field */
        foreach ($this->commandData->fields as $field) {
            if ($field->isForeignKey) {
                $templateName = 'fk_repo_param';
                $templateData = get_template("scaffold.controller.$templateName", 'vl-admin-tool');
                $templateData = fill_template($this->commandData->dynamicVars, $templateData);
                $params[] = trim(fill_template($this->commandData->generateFKVars($field), $templateData));
            }
        }

        if (count($params) == 0) return "";

        return ",\n" . implode(",\n", array_unique($params));
    }

    private function generateFKAssignments() {
        $params = [];

        /** @var GeneratorField $field */
        foreach ($this->commandData->fields as $field) {
            if ($field->isForeignKey) {
                $templateName = 'fk_repo_assign';
                $templateData = get_template("scaffold.controller.$templateName", 'vl-admin-tool');
                $templateData = fill_template($this->commandData->dynamicVars, $templateData);
                $params[] = trim(fill_template($this->commandData->generateFKVars($field), $templateData));
            }
        }

        if (count($params) == 0) return "";

        return "\n" . implode("\n", array_unique($params));
    }

    private function generateFKDeclarations() {
        $declaraions = [];

        /** @var GeneratorField $field */
        foreach ($this->commandData->fields as $field) {
            if ($field->isForeignKey) {
                $declaraions[] = $this->generateFKDeclaration($field);
            }
        }

        if (count($declaraions) == 0) return "";

        return "\n" . implode("\n", array_unique($declaraions));
    }

    private function generateFKDeclaration(GeneratorField $field) {
        $templateName = 'fk_repo_declaration';
        $templateData = get_template("scaffold.controller.$templateName", 'vl-admin-tool');

        return fill_template($this->commandData->generateFKVars($field), $templateData);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('Controllers file deleted: '.$this->fileName);
        }
    }
}

<?php

namespace Vuongdq\VLAdminTool\Common;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Models\Model;
use Vuongdq\VLAdminTool\Utils\GeneratorFieldsInputUtil;
use Vuongdq\VLAdminTool\Utils\TableFieldsGenerator;

class CommandData
{
    public static $COMMAND_TYPE_API = 'api';
    public static $COMMAND_TYPE_SCAFFOLD = 'scaffold';
    public static $COMMAND_TYPE_API_SCAFFOLD = 'api_scaffold';

    /** @var Model */
    public $modelObject;

    /** @var string */
    public $modelName;
    public $commandType;
    public $softDeleteField;

    /** @var GeneratorConfig */
    public $config;

    /** @var GeneratorField[] */
    public $fields = [];

    /** @var GeneratorFieldRelation[] */
    public $relations = [];

    /** @var Command */
    public $commandObj;

    /** @var TemplatesManager */
    private $templateManager;

    /** @var array */
    public $dynamicVars = [];
    public $fieldNamesMapping = [];
    public $timestampFields = [];

    /** @var CommandData */
    protected static $instance = null;

    public static function getInstance()
    {
        return self::$instance;
    }

    public function getTemplatesManager()
    {
        return $this->templateManager;
    }

    public function isLocalizedTemplates()
    {
        return $this->templateManager->isUsingLocale();
    }

    /**
     * @param Command          $commandObj
     * @param string           $commandType
     * @param TemplatesManager $templatesManager
     */
    public function __construct(Command $commandObj, $commandType, TemplatesManager $templatesManager = null)
    {
        $this->commandObj = $commandObj;

        if (is_null($templatesManager)) {
            $this->templateManager = app(TemplatesManager::class);
        } else {
            $this->templateManager = $templatesManager;
        }

        $this->commandType = $commandType;

        $this->fieldNamesMapping = [
            '$FIELD_NAME_TITLE$' => 'fieldTitle',
            '$FIELD_NAME$'       => 'name',
            '$FIELD_NAME_CAMEL$'       => 'fieldCamel',
        ];

        $this->config = new GeneratorConfig();
    }

    public function commandError($error)
    {
        $this->commandObj->error($error);
    }

    public function commandComment($message)
    {
        $this->commandObj->comment($message);
    }

    public function commandWarn($warning)
    {
        $this->commandObj->warn($warning);
    }

    public function commandInfo($message)
    {
        $this->commandObj->info($message);
    }

    public function initCommandData($options = null)
    {
        $this->config->init($this, $options);
    }

    public function getOption($option)
    {
        return $this->config->getOption($option);
    }

    public function getAddOn($option)
    {
        return $this->config->getAddOn($option);
    }

    public function setOption($option, $value)
    {
        $this->config->setOption($option, $value);
    }

    public function addDynamicVariable($name, $val)
    {
        $this->dynamicVars[$name] = $val;
    }

    public function getFields()
    {
        $this->fields = [];

        $this->getInputFromModel();
    }

    private function getInputFromModel() {
        $tableFieldsGenerator = new TableFieldsGenerator($this->modelObject);
        $tableFieldsGenerator->prepareFieldsFromModel();
        $tableFieldsGenerator->prepareRelations();

        $this->fields = $tableFieldsGenerator->fields;
        $this->timestampFields = $tableFieldsGenerator->timestamps;
        $this->softDeleteField = $tableFieldsGenerator->softDelete;
        $this->relations = $tableFieldsGenerator->relations;
    }

    private function addPrimaryKey()
    {
        $primaryKey = new GeneratorField();
        if ($this->getOption('primary')) {
            $primaryKey->name = $this->getOption('primary');
        } else {
            $primaryKey->name = 'id';
        }
        $primaryKey->parseDBType('increments');
        $primaryKey->parseOptions('s,f,p,if,ii');

        $this->fields[] = $primaryKey;
    }

    private function addTimestamps()
    {
        $createdAt = new GeneratorField();
        $createdAt->name = 'created_at';
        $createdAt->parseDBType('timestamp');
        $createdAt->parseOptions('s,f,if,ii');
        $this->fields[] = $createdAt;

        $updatedAt = new GeneratorField();
        $updatedAt->name = 'updated_at';
        $updatedAt->parseDBType('timestamp');
        $updatedAt->parseOptions('s,f,if,ii');
        $this->fields[] = $updatedAt;
    }

    private function getInputFromTable()
    {
        $tableName = $this->dynamicVars['$TABLE_NAME$'];

        $ignoredFields = $this->getOption('ignoreFields');
        if (!empty($ignoredFields)) {
            $ignoredFields = explode(',', trim($ignoredFields));
        } else {
            $ignoredFields = [];
        }

        $tableFieldsGenerator = new TableFieldsGenerator($tableName, $ignoredFields, $this->config->connection);
        $tableFieldsGenerator->prepareFieldsFromTable();
        $tableFieldsGenerator->prepareRelations();

        $this->fields = $tableFieldsGenerator->fields;
        $this->relations = $tableFieldsGenerator->relations;
    }

    public function isUseTimestamps() {
        return $this->modelObject->use_timestamps;
    }

    public function isUseSoftDelete() {
        return $this->modelObject->use_soft_delete;
    }
}

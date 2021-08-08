<?php

namespace Vuongdq\VLAdminTool\Utils;

use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\GeneratorField;
use Vuongdq\VLAdminTool\Common\GeneratorFieldRelation;
use Vuongdq\VLAdminTool\Common\GeneratorForeignKey;
use Vuongdq\VLAdminTool\Common\GeneratorTable;
use Vuongdq\VLAdminTool\Models\Field;
use Vuongdq\VLAdminTool\Models\Model;


class TableFieldsGenerator
{
    /** @var string */
    public $tableName;
    public $primaryKey;

    /** @var array */
    public $timestamps;

    /** @var Field[] */
    private $columns;

    /** @var GeneratorField[] */
    public $fields;

    /** @var GeneratorFieldRelation[] */
    public $relations;

    /** @var Model */
    public $modelObject;
    /**
     * @var string
     */
    public $softDelete;


    public function __construct(Model $modelObject)
    {
        $this->modelObject = $modelObject;
        $this->tableName = $modelObject->getAttributes('table_name');

        $this->columns = $this->getTableColumns();

        $this->primaryKey = $this->getPrimaryKeyOfTable();
        $this->timestamps = $this->getTimestampFieldNames();
        $this->softDelete = $this->getSoftDeleteFieldName();
        $this->fields = [];
    }

    public function getTableColumns() {
        return $this->modelObject->fields;
    }

    public function generateTimestampField($columnName) {
        $field = new GeneratorField();
        $field->name = $columnName;
        $field->parseDBTypeFromModel("timestamp", null);

        # crud rules
        $field->validations = '';
        $field->isCreatable = false;
        $field->isEditable = false;

        # datatables rules
        $field->isShowable = false;
        $field->isSearchable = false;
        $field->isOrderable = false;
        $field->isExportable = false;
        $field->isPrintable = false;
        $field->cssClasses = "";
        return $field;
    }

    public function generateSoftDeleteFields() {
        $field = $this->generateTimestampField($this->softDelete);
        $this->fields[] = $field;
    }

    public function generateTimestampFields() {
        foreach ($this->timestamps as $columnName) {
            $field = $this->generateTimestampField($columnName);
            $this->fields[] = $field;
        }
    }

    /**
     * Prepares array of GeneratorField from table columns.
     */
    public function prepareFieldsFromModel()
    {
        $datetimeColumns = array_merge($this->timestamps, is_null($this->softDelete) ? [] : [$this->softDelete]);

        foreach ($this->columns as $column) {
            $htmlType = $column->html_type;
            if ($htmlType == 'checkbox') $htmlType .= ',1';

            $field = $this->generateField($column, $column->dbConfig->type, $htmlType);

            if (in_array($field->name, $datetimeColumns)) {
                $field->isSearchable = false;
//                $field->isCreatable = false;
//                $field->inEditable = false;
            }
            $field->isNotNull = !$column->dbConfig->nullable;
            $field->description = '';

            $this->fields[] = $field;
        }

        $this->generateTimestampFields();
        if ($this->softDelete !== null && $this->softDelete !== "") $this->generateSoftDeleteFields();
    }

    /**
     * Get primary key of given table.
     *
     * @return string|null The column name of the (simple) primary key
     */
    public function getPrimaryKeyOfTable()
    {
        foreach ($this->columns as $column)
            if ($column->dbConfig->type === 'id')
                return $column->name;
    }

    /**
     * Get timestamp columns from config.
     *
     * @return array the set of [created_at column name, updated_at column name]
     */
    public function getTimestampFieldNames()
    {
        if (!$this->modelObject->use_timestamps) {
            return [];
        }

        $createdAtName = config('vl_admin_tool.timestamps.created_at', 'created_at');
        $updatedAtName = config('vl_admin_tool.timestamps.updated_at', 'updated_at');

        return [$createdAtName, $updatedAtName];
    }

    public function getSoftDeleteFieldName() {
        if (!$this->modelObject->use_soft_delete) {
            return null;
        }

        $deletedAtName = config('vl_admin_tool.timestamps.deleted_at', 'deleted_at');

        return $deletedAtName;
    }

    /**
     * Check if key is primary key and sets field options.
     *
     * @param GeneratorField $field
     *
     * @return GeneratorField
     */
    private function checkForPrimary(GeneratorField $field)
    {
        if ($field->name == $this->primaryKey) {
            $field->isPrimary = true;
            $field->isSearchable = false;
        }

        return $field;
    }

    /**
     * Generates field.
     *
     * @param Field $column
     * @param $dbType
     * @param $htmlType
     *
     * @return GeneratorField
     */
    private function generateField(Field $column, $dbType, $htmlType)
    {
        $field = new GeneratorField();
        $field->name = $column->name;
        $field->parseDBTypeFromModel($dbType, $column);
        $field->parseHtmlInput($htmlType);

        # crud rules
        $crudConfig = $column->crudConfig;
        $field->validations = $crudConfig->rules ?? '';
        $field->isCreatable = $crudConfig->creatable ?? true;
        $field->isEditable = $crudConfig->editable ?? true;

        # datatables rules
        $dtConfig = $column->dtConfig;
        $field->isShowable = $dtConfig->showable ?? false;
        $field->isSearchable = $dtConfig->searchable ?? false;
        $field->isOrderable = $dtConfig->orderable ?? true;
        $field->isExportable = $dtConfig->exportable ?? false;
        $field->isPrintable = $dtConfig->printable ?? true;
        $field->cssClasses = $dtConfig->class ?? "";

        return $this->checkForPrimary($field);
    }

    /**
     * Generates number field.
     *
     * @param Column $column
     * @param string $dbType
     *
     * @return GeneratorField
     */
    private function generateNumberInput($column, $dbType)
    {
        $field = new GeneratorField();
        $field->name = $column->getName();
        $field->parseDBType($dbType.','.$column->getPrecision().','.$column->getScale());
        $field->htmlType = 'number';

        if ($dbType === 'decimal') {
            $field->numberDecimalPoints = $column->getScale();
        }

        return $this->checkForPrimary($field);
    }

    /**
     * Prepares relations (GeneratorFieldRelation) array from table foreign keys.
     */
    public function prepareRelations()
    {
        $fields = $this->modelObject->fields;
        $relations = collect([]);
        foreach ($fields as $field) {
            $relations = $relations->concat($field->relations);
        }

        foreach ($relations as $relation) {
            $fieldRelation = GeneratorFieldRelation::parseRelationFromModel($relation);
            $this->relations[] = $fieldRelation;
        }
    }
}

<?php

namespace Vuongdq\VLAdminTool\Utils;

use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\GeneratorField;
use Vuongdq\VLAdminTool\Common\GeneratorFieldRelation;
use Vuongdq\VLAdminTool\Models\Field;
use Vuongdq\VLAdminTool\Models\Model;

class GeneratorForeignKey
{
    /** @var string */
    public $name;
    public $localField;
    public $foreignField;
    public $foreignTable;
    public $onUpdate;
    public $onDelete;
}

class GeneratorTable
{
    /** @var string */
    public $primaryKey;

    /** @var GeneratorForeignKey[] */
    public $foreignKeys;
}

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
    private $softDelete;


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
        $this->generateSoftDeleteFields();
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
     * Generates integer text field for database.
     *
     * @param string $dbType
     * @param Column $column
     *
     * @return GeneratorField
     */
    private function generateIntFieldInput($column, $dbType)
    {
        $field = new GeneratorField();
        $field->name = $column->getName();
        $field->parseDBType($dbType);
        $field->htmlType = 'number';

        if ($column->getAutoincrement()) {
            $field->dbInput .= ',true';
        } else {
            $field->dbInput .= ',false';
        }

        if ($column->getUnsigned()) {
            $field->dbInput .= ',true';
        }

        return $this->checkForPrimary($field);
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
        $foreignKeys = $this->prepareForeignKeys();
        $this->checkForRelations($foreignKeys);
    }

    /**
     * Prepares foreign keys from table with required details.
     *
     * @return GeneratorTable[]
     */
    public function prepareForeignKeys()
    {
        $tables = $this->schemaManager->listTables();

        $fields = [];

        foreach ($tables as $table) {
            $primaryKey = $table->getPrimaryKey();
            if ($primaryKey) {
                $primaryKey = $primaryKey->getColumns()[0];
            }
            $formattedForeignKeys = [];
            $tableForeignKeys = $table->getForeignKeys();
            foreach ($tableForeignKeys as $tableForeignKey) {
                $generatorForeignKey = new GeneratorForeignKey();
                $generatorForeignKey->name = $tableForeignKey->getName();
                $generatorForeignKey->localField = $tableForeignKey->getLocalColumns()[0];
                $generatorForeignKey->foreignField = $tableForeignKey->getForeignColumns()[0];
                $generatorForeignKey->foreignTable = $tableForeignKey->getForeignTableName();
                $generatorForeignKey->onUpdate = $tableForeignKey->onUpdate();
                $generatorForeignKey->onDelete = $tableForeignKey->onDelete();

                $formattedForeignKeys[] = $generatorForeignKey;
            }

            $generatorTable = new GeneratorTable();
            $generatorTable->primaryKey = $primaryKey;
            $generatorTable->foreignKeys = $formattedForeignKeys;

            $fields[$table->getName()] = $generatorTable;
        }

        return $fields;
    }

    /**
     * Prepares relations array from table foreign keys.
     *
     * @param GeneratorTable[] $tables
     */
    private function checkForRelations($tables)
    {
        // get Models table name and table details from tables list
        $modelTableName = $this->tableName;
        $modelTable = $tables[$modelTableName];
        unset($tables[$modelTableName]);

        $this->relations = [];

        // detects many to one rules for model table
        $manyToOneRelations = $this->detectManyToOne($tables, $modelTable);

        if (count($manyToOneRelations) > 0) {
            $this->relations = array_merge($this->relations, $manyToOneRelations);
        }

        foreach ($tables as $tableName => $table) {
            $foreignKeys = $table->foreignKeys;
            $primary = $table->primaryKey;

            // if foreign key count is 2 then check if many to many relationship is there
            if (count($foreignKeys) == 2) {
                $manyToManyRelation = $this->isManyToMany($tables, $tableName, $modelTable, $modelTableName);
                if ($manyToManyRelation) {
                    $this->relations[] = $manyToManyRelation;
                    continue;
                }
            }

            // iterate each foreign key and check for relationship
            foreach ($foreignKeys as $foreignKey) {
                // check if foreign key is on the model table for which we are using generator command
                if ($foreignKey->foreignTable == $modelTableName) {

                    // detect if one to one relationship is there
                    $isOneToOne = $this->isOneToOne($primary, $foreignKey, $modelTable->primaryKey);
                    if ($isOneToOne) {
                        $modelName = model_name_from_table_name($tableName);
                        $this->relations[] = GeneratorFieldRelation::parseRelation('1t1,'.$modelName);
                        continue;
                    }

                    // detect if one to many relationship is there
                    $isOneToMany = $this->isOneToMany($primary, $foreignKey, $modelTable->primaryKey);
                    if ($isOneToMany) {
                        $modelName = model_name_from_table_name($tableName);
                        $this->relations[] = GeneratorFieldRelation::parseRelation(
                            '1tm,'.$modelName.','.$foreignKey->localField
                        );
                        continue;
                    }
                }
            }
        }
    }

    /**
     * Detects many to many relationship
     * If table has only two foreign keys
     * Both foreign keys are primary key in foreign table
     * Also one is from model table and one is from diff table.
     *
     * @param GeneratorTable[] $tables
     * @param string           $tableName
     * @param GeneratorTable   $modelTable
     * @param string           $modelTableName
     *
     * @return bool|GeneratorFieldRelation
     */
    private function isManyToMany($tables, $tableName, $modelTable, $modelTableName)
    {
        // get table details
        $table = $tables[$tableName];

        $isAnyKeyOnModelTable = false;

        // many to many model table name
        $manyToManyTable = '';

        $foreignKeys = $table->foreignKeys;
        $primary = $table->primaryKey;

        // check if any foreign key is there from model table
        foreach ($foreignKeys as $foreignKey) {
            if ($foreignKey->foreignTable == $modelTableName) {
                $isAnyKeyOnModelTable = true;
            }
        }

        // if foreign key is there
        if (!$isAnyKeyOnModelTable) {
            return false;
        }

        foreach ($foreignKeys as $foreignKey) {
            $foreignField = $foreignKey->foreignField;
            $foreignTableName = $foreignKey->foreignTable;

            // if foreign table is model table
            if ($foreignTableName == $modelTableName) {
                $foreignTable = $modelTable;
            } else {
                $foreignTable = $tables[$foreignTableName];
                // get the many to many model table name
                $manyToManyTable = $foreignTableName;
            }

            // if foreign field is not primary key of foreign table
            // then it can not be many to many
            if ($foreignField != $foreignTable->primaryKey) {
                return false;
                break;
            }

            // if foreign field is primary key of this table
            // then it can not be many to many
            if ($foreignField == $primary) {
                return false;
            }
        }

        if (empty($manyToManyTable)) {
            return false;
        }

        $modelName = model_name_from_table_name($manyToManyTable);

        return GeneratorFieldRelation::parseRelation('mtm,'.$modelName.','.$tableName);
    }

    /**
     * Detects if one to one relationship is there
     * If foreign key of table is primary key of foreign table
     * Also foreign key field is primary key of this table.
     *
     * @param string              $primaryKey
     * @param GeneratorForeignKey $foreignKey
     * @param string              $modelTablePrimary
     *
     * @return bool
     */
    private function isOneToOne($primaryKey, $foreignKey, $modelTablePrimary)
    {
        if ($foreignKey->foreignField == $modelTablePrimary) {
            if ($foreignKey->localField == $primaryKey) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detects if one to many relationship is there
     * If foreign key of table is primary key of foreign table
     * Also foreign key field is not primary key of this table.
     *
     * @param string              $primaryKey
     * @param GeneratorForeignKey $foreignKey
     * @param string              $modelTablePrimary
     *
     * @return bool
     */
    private function isOneToMany($primaryKey, $foreignKey, $modelTablePrimary)
    {
        if ($foreignKey->foreignField == $modelTablePrimary) {
            if ($foreignKey->localField != $primaryKey) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect many to one relationship on model table
     * If foreign key of model table is primary key of foreign table.
     *
     * @param GeneratorTable[] $tables
     * @param GeneratorTable   $modelTable
     *
     * @return array
     */
    private function detectManyToOne($tables, $modelTable)
    {
        $manyToOneRelations = [];

        $foreignKeys = $modelTable->foreignKeys;

        foreach ($foreignKeys as $foreignKey) {
            $foreignTable = $foreignKey->foreignTable;
            $foreignField = $foreignKey->foreignField;

            if (!isset($tables[$foreignTable])) {
                continue;
            }

            if ($foreignField == $tables[$foreignTable]->primaryKey) {
                $modelName = model_name_from_table_name($foreignTable);
                $manyToOneRelations[] = GeneratorFieldRelation::parseRelation(
                    'mt1,'.$modelName.','.$foreignKey->localField
                );
            }
        }

        return $manyToOneRelations;
    }
}

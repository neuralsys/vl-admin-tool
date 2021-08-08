<?php

namespace Vuongdq\VLAdminTool\Commands;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Schema\Table;
use Doctrine\Tests\Common\Annotations\Name;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Vuongdq\VLAdminTool\Common\GeneratorFieldRelation;
use Vuongdq\VLAdminTool\Common\GeneratorForeignKey;
use Vuongdq\VLAdminTool\Common\GeneratorTable;
use Vuongdq\VLAdminTool\Models\DBConfig;
use Vuongdq\VLAdminTool\Models\Field;
use Vuongdq\VLAdminTool\Models\Model;
use Vuongdq\VLAdminTool\Models\Relation;
use Vuongdq\VLAdminTool\Repositories\CRUDConfigRepository;
use Vuongdq\VLAdminTool\Repositories\DTConfigRepository;
use Vuongdq\VLAdminTool\Repositories\FieldRepository;
use Vuongdq\VLAdminTool\Repositories\ModelRepository;
use Vuongdq\VLAdminTool\Repositories\DBConfigRepository;
use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Repositories\RelationRepository;
use function Matrix\trace;

class DBSyncCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vlat:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suync current DB Connection with VL Admin Tool';

    /**
     *
     * @var AbstractSchemaManager
     */
    public $schemaManager = null;

    /**
     *
     * @var ModelRepository
     */
    public $modelRepository;

    /**
     *
     * @var FieldRepository
     */
    public $fieldRepository;

    /**
     *
     * @var DBConfigRepository
     */
    public $dbConfigRepository;

    /**
     *
     * @var DTConfigRepository
     */
    public $dtConfigRepository;

    /**
     *
     * @var CRUDConfigRepository
     */
    public $crudConfigRepository;

    /**
     *
     * @var GeneratorTable[]
     */
    public $foreignKeys;

    /** @var GeneratorFieldRelation[] */
    public $relations;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->modelRepository = app(ModelRepository::class);
        $this->fieldRepository = app(FieldRepository::class);
        $this->dbConfigRepository = app(DBConfigRepository::class);
        $this->dtConfigRepository = app(DTConfigRepository::class);
        $this->crudConfigRepository = app(CRUDConfigRepository::class);
        $this->relationRepository = app(RelationRepository::class);
        $this->ignoreTables = array_merge([
            'migrations',
        ], $this->getAdminTableNames());
        $this->schemaManager = DB::getDoctrineSchemaManager();
        $platform = $this->schemaManager->getDatabasePlatform();
        $defaultMappings = [
            'enum' => 'string',
            'json' => 'text',
            'bit' => 'boolean',
            'tinyinteger' => 'boolean',
        ];

        $mappings = config('vl_admin_tool.from_table.doctrine_mappings', []);
        $mappings = array_merge($mappings, $defaultMappings);
        foreach ($mappings as $dbType => $doctrineType) {
            $platform->registerDoctrineTypeMapping($dbType, $doctrineType);
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fetching tables from DB connection...');
        $this->getTablesFromTable();
        $this->info('Syncing DB successfully!');
        return 0;
    }

    public function getOptions()
    {
        return [];
    }

    public function getArguments()
    {
        return [];
    }

    public function isUseTimestamps(Table $table): bool
    {
        try {
            $table->getColumn('created_at');
            $table->getColumn('updated_at');
            return true;
        } catch (SchemaException $e) {
            return false;
        }
        return false;
    }

    public function isUseSoftDelete(Table $table)
    {
        try {
            $table->getColumn('deleted_at');
            return true;
        } catch (SchemaException $e) {
            return false;
        }
        return false;
    }

    public function createOrUpdateTable(Table $table)
    {
        $tableName = $table->getName();

        $model = $this->modelRepository->where('table_name', $table->getName())->first();
        if (empty($model)) {
            $model = $this->modelRepository->create([
                'class_name' => Str::ucfirst(Str::camel(Str::singular($tableName))),
                'table_name' => $tableName,
                'singular' => Str::lower(Str::singular($tableName)),
                'plural' => Str::lower(Str::plural($tableName)),
                'description' => "",
                'use_timestamps' => $this->isUseTimestamps($table),
                'use_soft_delete' => $this->isUseSoftDelete($table)
            ]);
        } else {
            $model->update([
                'class_name' => Str::ucfirst(Str::camel(Str::singular($tableName))),
                'table_name' => $tableName,
                'singular' => Str::lower(Str::singular($tableName)),
                'plural' => Str::lower(Str::plural($tableName)),
                'use_timestamps' => $this->isUseTimestamps($table),
                'use_soft_delete' => $this->isUseSoftDelete($table)
            ]);
        }
        return $model;
    }

    public function createOrUpdateField(Model $model, Column $column)
    {
        $field = $this->fieldRepository
            ->where("model_id", $model->id)
            ->where("name", $column->getName())
            ->first();

        if (empty($field)) {
            $field = $this->fieldRepository->create([
                'model_id' => $model->id,
                'name' => $column->getName(),
                'html_type' => $column->getType()->getName()
            ]);
        } else {
            $field->update([
                'html_type' => $column->getType()->getName()
            ]);
        }
        return $field;
    }

    public function predictDBConfig(Column $column)
    {
        $res = [
            'type' => null,
            'length' => $column->getLength(),
            'nullable' => !$column->getNotnull(),
            'unique' => false,
            'default' => $column->getDefault()
        ];

        if ($column->getName() == "id") {
            $res['type'] = "id";
            return $res;
        }
        $type = $column->getType()->getName();

        switch ($type) {
            case 'integer':
                $res['type'] = 'integer';
                break;
            case 'smallint':
                $res['type'] = 'smallInteger';
                break;
            case 'bigint':
                $res['type'] = 'bigInteger';
                break;
            case 'boolean':
                $res['type'] = 'boolean';
                break;
            case 'datetime':
                $res['type'] = 'timestamp';
                break;
            case 'datetimetz':
                $res['type'] = 'dateTimeTz';
                break;
            case 'date':
                $res['type'] = 'date';
                break;
            case 'time':
                $res['type'] = 'time';
                break;
            case 'decimal':
                $res['type'] = 'decimal';
                break;
            case 'float':
                $res['type'] = 'float';
                break;
            case 'string':
                $res['type'] = 'string';
                break;
            case 'text':
                $res['type'] = 'text';
                break;
            default:
                $res['type'] = 'string';
                break;
        }
        return $res;
    }

    public function createOrUpdateDBConfig(Field $field, Column $column)
    {
        $dbConfig = $field->dbConfig;
        $dbConf = $this->predictDBConfig($column);
        if (empty($dbConfig)) {
            $dbConfig = $this->dbConfigRepository->create(array_merge([
                'field_id' => $field->id,
            ], $dbConf));
        } else {
            $dbConfig->update(array_merge([
                'field_id' => $field->id,
            ], $dbConf));
        }
        return $dbConfig;
    }

    public function predictDTConfig(Field $field, DBConfig $dbConfig, Column $column, array $primaryColumns): array
    {
        $isPK = in_array($field->name, $primaryColumns);
        $isFK = strpos($field->name, '_id') !== false; # Todo: update logic for all cases
        $isFKorPK = $isPK || $isFK;

        $isPassword = strpos($field->name, 'password') !== false;
        $isSearchable = in_array($dbConfig->type, ['string', 'text']);

        $isSearchable = ($isSearchable || $isFKorPK) && !$isPassword;

        return [
            'showable' => !$isPK && !$isPassword,
            'searchable' => $isSearchable,
            'orderable' => false,
            'exportable' => !$isFKorPK && !$isPassword,
            'printable' => !$isFKorPK && !$isPassword,
            'class' => null,
            'has_footer' => false
        ];
    }

    public function createOrUpdateDTConfig(Field $field, DBConfig $dbConfig, Column $column, array $primaryColumns)
    {
        $dtConfig = $field->dtConfig;
        $dtConf = $this->predictDTConfig($field, $dbConfig, $column, $primaryColumns);
        if (empty($dtConfig)) {
            $dtConfig = $this->dtConfigRepository->create(array_merge([
                'field_id' => $field->id,
            ], $dtConf));
        } else {
            $dtConfig->update(array_merge([
                'field_id' => $field->id,
            ], $dtConf));
        }
        return $dtConfig;
    }

    public function generateRules(Field $field, DBConfig $dbConfig, Column $column, $isPK): string
    {
        $rule = [];
        if (!$isPK) {
            # Required or Nullable
            if (!$dbConfig->nullable) {
                $rule[] = "required";
            }
            else {
                $rule[] = "sometimes|nullable";
            }

            # Type of value
            switch ($dbConfig->type) {
                case 'integer':
                    $rule[] = 'integer';
                    break;
                case 'boolean':
                    $rule[] = 'boolean';

                    # Available values
                    $rule[] = "in:1,0";
                    break;
                case 'float':
                case 'double':
                case 'decimal':
                    $rule[] = 'numeric';
                    break;
                case 'string':
                    $rule[] = 'string';
                    # size of value
                    $rule[] = 'max:' . $dbConfig->length;
                    break;
                case 'text':
                    $rule[] = 'string';
                    break;
            }

            # unique at the end
            if ($dbConfig->unique) $rule[] = "unique";
        }

        return implode('|', $rule);
    }

    public function predictCRUDConfig(Field $field, DBConfig $dbConfig, Column $column, $primaryColumns)
    {
        $isPK = in_array($field->name, $primaryColumns);
        return [
            'creatable' => !$isPK,
            'editable' => !$isPK,
            'rules' => $this->generateRules($field, $dbConfig, $column, $isPK)
        ];
    }

    public function createOrUpdateCRUDConfig(Field $field, DBConfig $dbConfig, Column $column, $primaryColumns)
    {
        $crudConfig = $field->crudConfig;
        $crudConf = $this->predictCRUDConfig($field, $dbConfig, $column, $primaryColumns);
        if (empty($crudConfig)) {
            $crudConfig = $this->crudConfigRepository->create(array_merge([
                'field_id' => $field->id,
            ], $crudConf));
        } else {
            $crudConfig->update(array_merge([
                'field_id' => $field->id,
            ], $crudConf));
        }
        return $crudConfig;
    }

    public function updateHTMLType(Field $field, DBConfig $dbConfig) {
        $name = $field->name;
        $type = $dbConfig->type;

        $htmlType = app("ViewMapping")->predictHTMLType($name, $type);

        $field->update([
            "html_type" => $htmlType
        ]);

        return $field;
    }

    public function extractRelationsByColumn(Field $field, Table $table)
    {
        $fieldRelations = [];
        foreach ($this->relations as $relation) {
            $foreignKeys = $relation->foreignKeys;
            if (count($foreignKeys) > 0) {
                switch ($relation->type) {
                    case "1-1i":
                        if ($foreignKeys[0]->localField == $field->name) {
                            $fieldRelations[] = $relation;
                        }
                        break;
                    case "1-1":
                        if ($foreignKeys[0]->foreignField == $field->name) {
                            $fieldRelations[] = $relation;
                        }
                        break;
                    case "1-n":
                        if ($foreignKeys[0]->foreignField == $field->name) {
                            $fieldRelations[] = $relation;
                        }
                        break;
                    case "n-1":
                        if ($foreignKeys[0]->localField == $field->name) {
                            $fieldRelations[] = $relation;
                        }
                        break;
                    case "m-n":
                        foreach ($foreignKeys as $foreignKey) {
                            if ($foreignKey->foreignTable == $table->getName() && $foreignKey->foreignField == $field->name) {
                                $fieldRelations[] = $relation;
                            }
                        }
                        break;
                }
            }
        }

        return $fieldRelations;
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
    private function detectManyToOneOrOneToOneInverse($tables, $modelTable)
    {
        $manyToOneRelations = [];

        $foreignKeys = $modelTable->foreignKeys;
        $primary = $modelTable->primaryKey;

        foreach ($foreignKeys as $foreignKey) {
            $foreignTable = $foreignKey->foreignTable;
            $foreignField = $foreignKey->foreignField;

            if (!isset($tables[$foreignTable])) {
                continue;
            }

            if ($foreignField == $tables[$foreignTable]->primaryKey) {
                $modelName = model_name_from_table_name($foreignTable);
                if ($foreignKey->localField != $primary) {
                    $relations = GeneratorFieldRelation::parseRelation(
                        'n-1,'.$modelName.','.$foreignKey->localField
                    );
                } else {
                    $relations = GeneratorFieldRelation::parseRelation(
                        '1-1i,'.$modelName.','.$foreignKey->localField
                    );
                }

                $relations->foreignKeys[] = $foreignKey;
                $manyToOneRelations[] = $relations;
            }
        }

        return $manyToOneRelations;
    }

    /**
     * Prepares relations array from table foreign keys.
     *
     * @param GeneratorTable[] $tables
     * @param Table $table
     */
    private function checkForRelations($tables, Table $table)
    {
        // get Models table name and table details from tables list
        $modelTableName = $table->getName();
        $modelTable = $tables[$modelTableName];
        unset($tables[$modelTableName]);

        $this->relations = [];

        // detects many to one rules for model table
        $manyToOneRelations = $this->detectManyToOneOrOneToOneInverse($tables, $modelTable);

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
                        $relations = GeneratorFieldRelation::parseRelation('1-1,'.$modelName);
                        $relations->foreignKeys[] = $foreignKey;
                        $this->relations[] = $relations;
                        continue;
                    }

                    // detect if one to many relationship is there
                    $isOneToMany = $this->isOneToMany($primary, $foreignKey, $modelTable->primaryKey);
                    if ($isOneToMany) {
                        $modelName = model_name_from_table_name($tableName);
                        $relations = GeneratorFieldRelation::parseRelation(
                            '1-n,'.$modelName.','.$foreignKey->localField
                        );
                        $relations->foreignKeys[] = $foreignKey;
                        $this->relations[] = $relations;
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
        }

        if (empty($manyToManyTable)) {
            return false;
        }

        $modelName = model_name_from_table_name($manyToManyTable);

        $relation = GeneratorFieldRelation::parseRelation('m-n,'.$modelName.','.$tableName);
        $relation->foreignKeys = array_merge($relation->foreignKeys, $foreignKeys);
        return $relation;
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

    public function findSecondFieldIdByRelation(GeneratorFieldRelation $relation, Field $field, Table $table) {
        $secondFieldId = null;
        $foreignKeys = $relation->foreignKeys;
        $foreignTable = $this->modelRepository->where('class_name', $relation->inputs[0])->first();
        if (count($foreignKeys) > 0) {
            switch ($relation->type) {
                case "1-1i":
                    $foreignField = $foreignTable->fields()->where('name', $foreignKeys[0]->foreignField)->first();
                    $secondFieldId = $foreignField->id;
                    break;
                case "1-1":
                    $foreignField = $foreignTable->fields()->where('name', $foreignKeys[0]->localField)->first();
                    $secondFieldId = $foreignField->id;
                    break;
                case "1-n":
                    $foreignField = $foreignTable->fields()->where('name', $relation->inputs[1])->first();
                    $secondFieldId = $foreignField->id;
                    break;
                case "n-1":
                    $foreignField = $foreignTable->fields()->where('name', $foreignKeys[0]->foreignField)->first();
                    $secondFieldId = $foreignField->id;
                    break;
                case "m-n":
                    $correctForeignKey = null;
                    foreach ($foreignKeys as $foreignKey) {
                        if ($foreignKey->foreignTable != $table->getName()) {
                            $correctForeignKey = $foreignKey;
                        }
                    }

                    if (!empty($correctForeignKey)) {
                        $foreignField = $foreignTable->fields()->where('name', $correctForeignKey->foreignField)->first();;
                        $secondFieldId = $foreignField->id;
                    }

                    break;
            }
        }

        return $secondFieldId;
    }

    public function createRelationsByColumn(Table $table, Field $field) {
        $fieldRelations = $this->extractRelationsByColumn($field, $table);

        foreach ($fieldRelations as $fieldRelation) {
            $firstFieldId = $field->id;
            $secondFieldId = $this->findSecondFieldIdByRelation($fieldRelation, $field, $table);

            $relation = new Relation();
            $relation->first_field_id = $firstFieldId;
            $relation->second_field_id = $secondFieldId;
            $relation->type = $fieldRelation->type;

            if (!empty($secondFieldId)) {
                if ($fieldRelation->type == "m-n") {
                    $relation->table_name = $fieldRelation->inputs[1];
                    $firstTable = $fieldRelation->foreignKeys[0]->foreignTable;

                    if ($table->getName() == $firstTable) {
                        $relation->fk_1 = $fieldRelation->foreignKeys[0]->localField;
                        $relation->fk_2 = $fieldRelation->foreignKeys[1]->localField;
                    } else {
                        $relation->fk_1 = $fieldRelation->foreignKeys[1]->localField;
                        $relation->fk_2 = $fieldRelation->foreignKeys[0]->localField;
                    }
                }
            }

            $relation->save();
        }
    }

    public function createOrUpdateRelations(Table $table) {
        $model = $this->modelRepository->where('table_name', $table->getName())->first();
        $fields = $model->fields;

        foreach ($fields as $field) {
            $field->relations()->delete();
            $this->createRelationsByColumn($table, $field);
        }
    }

    public function createOrUpdateColumn(Table $table, Model $model, array $primaryColumns)
    {
        $columns = $table->getColumns();

        # delete column
        $fields = $model->fields;
        $columnNames = array_map(function (Column $column) {
            return $column->getName();
        }, array_filter($columns, function (Column $column) {
            return !in_array($column->getName(), ['created_at', 'updated_at', 'deleted_at']);
        }));

        foreach ($fields as $field) {
            if (!in_array($field->name, $columnNames)) $field->delete();
        }

        foreach ($columns as $column) {
            if (in_array($column->getName(), ['created_at', 'deleted_at', 'updated_at'])) continue;
            $field = $this->createOrUpdateField($model, $column);
            $dbConfig = $this->createOrUpdateDBConfig($field, $column);
            $dtConfig = $this->createOrUpdateDTConfig($field, $dbConfig, $column, $primaryColumns);
            $crudConfig = $this->createOrUpdateCRUDConfig($field, $dbConfig, $column, $primaryColumns);
            $field = $this->updateHTMLType($field, $dbConfig);
        }
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

    public function syncTable(Table $table)
    {
        DB::beginTransaction();
        try {
            $this->checkForRelations($this->foreignKeys, $table);

            $model = $this->createOrUpdateTable($table);
            try {
                $primaryKeys = $table->getPrimaryKeyColumns();
            } catch (\Exception $e) {
                $primaryKeys = [];
            }
            $this->createOrUpdateColumn($table, $model, $primaryKeys);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $this->createOrUpdateRelations($table);
    }

    public function removeInvalidTables($tables) {
        $tableNames = array_map(function (Table $table) {
            return $table->getName();
        }, $tables);

        $models = $this->modelRepository->all();
        foreach ($models as $model) {
            if (!in_array($model->table_name, $tableNames)) $model->delete();
        }
    }

    public function getTablesFromTable()
    {
        $tables = $this->schemaManager->listTables();
        $this->removeInvalidTables($tables);

        foreach ($tables as $table) {
            if (in_array($table->getName(), $this->ignoreTables))
                continue;

            $this->foreignKeys = $this->prepareForeignKeys($table);
            $this->syncTable($table);
        }
    }
}

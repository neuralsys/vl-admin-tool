<?php

namespace Vuongdq\VLAdminTool\Commands;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Schema\Table;
use Doctrine\Tests\Common\Annotations\Name;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Vuongdq\VLAdminTool\Models\DBConfig;
use Vuongdq\VLAdminTool\Models\Field;
use Vuongdq\VLAdminTool\Models\Model;
use Vuongdq\VLAdminTool\Repositories\CRUDConfigRepository;
use Vuongdq\VLAdminTool\Repositories\DTConfigRepository;
use Vuongdq\VLAdminTool\Repositories\FieldRepository;
use Vuongdq\VLAdminTool\Repositories\ModelRepository;
use Vuongdq\VLAdminTool\Repositories\DBConfigRepository;
use Illuminate\Support\Str;

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

    public function isUseTimestamps(Table $table)
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
                $res['type'] = 'datetime';
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

    public function predictDTConfig(Field $field, DBConfig $dbConfig, Column $column, array $primayColumns)
    {
        $isPK = in_array($field->name, $primayColumns);
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

    public function createOrUpdateDTConfig(Field $field, DBConfig $dbConfig, Column $column, array $primayColumns)
    {
        $dtConfig = $field->dtConfig;
        $dtConf = $this->predictDTConfig($field, $dbConfig, $column, $primayColumns);
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

    public function generateRules(Field $field, DBConfig $dbConfig, Column $column, $isPK)
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

                    # Avalidable values
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

    public function predictCRUDConfig(Field $field, DBConfig $dbConfig, Column $column, $primayColumns)
    {
        $isPK = in_array($field->name, $primayColumns);
        return [
            'creatable' => !$isPK,
            'editable' => !$isPK,
            'rules' => $this->generateRules($field, $dbConfig, $column, $isPK)
        ];
    }

    public function createOrUpdateCRUDConfig(Field $field, DBConfig $dbConfig, Column $column, $primayColumns)
    {
        $crudConfig = $field->crudConfig;
        $crudConf = $this->predictCRUDConfig($field, $dbConfig, $column, $primayColumns);
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

    public function createOrUpdateColumn(Table $table, Model $model, array $primayColumns)
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
            $dtConfig = $this->createOrUpdateDTConfig($field, $dbConfig, $column, $primayColumns);
            $crudConfig = $this->createOrUpdateCRUDConfig($field, $dbConfig, $column, $primayColumns);
            $field = $this->updateHTMLType($field, $dbConfig);
        }
    }

    public function syncTable(Table $table)
    {
        DB::beginTransaction();
        try {
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
            $this->syncTable($table);
        }
    }
}

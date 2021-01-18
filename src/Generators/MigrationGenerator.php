<?php

namespace Vuongdq\VLAdminTool\Generators;

use File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Utils\FileUtil;
use SplFileInfo;

class MigrationGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    public function __construct($commandData)
    {
        $this->commandData = $commandData;
        $this->path = config('vl_admin_tool.path.migration', database_path('migrations/'));
    }

    public function generate()
    {
        $templateData = get_template('migration', 'vl-admin-tool');

        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace('$FIELDS$', $this->generateFields(), $templateData);

        $tableName = $this->commandData->dynamicVars['$TABLE_NAME$'];

        $fileName = $this->updateOrCreateFileName('create_'.strtolower($tableName).'_table.php', $templateData);

        $this->commandData->commandComment("\nMigration created: ");
        $this->commandData->commandInfo($fileName);
    }

    private function updateOrCreateFileName(string $mainText, $templateData) {
        $migrationFile = $this->getMigrationFile([$this->path], $mainText);
        if ($migrationFile) {
            $fileName = pathinfo($migrationFile)['filename'].'.php';
            FileUtil::deleteFile($this->path, $fileName);
        }
        else $fileName = date('Y_m_d_His').'_'.$mainText;
        FileUtil::createFile($this->path, $fileName, $templateData);
        return $fileName;
    }

    /**
     * Get all of the migration files in a given path.
     *
     * @param string|array $paths
     * @param string $mainText
     * @return mixed
     */
    public function getMigrationFile($paths, string $mainText)
    {
        return Collection::make($paths)
            ->flatMap(function ($path) {
                return Str::endsWith($path, ".php") ? [$path] : glob($path.'*_*.php');
            })
            ->filter( function ($path) use ($mainText) {
                return Str::endsWith($path, $mainText);
            })
            ->values()->keyBy(function ($file) {
                return $this->getMigrationName($file);
            })
            ->sortBy(function ($file, $key) {
                return $key;
            })
            ->first();
    }

    /**
     * Get the name of the migration.
     *
     * @param  string  $path
     * @return string
     */
    public function getMigrationName($path)
    {
        return str_replace('.php', '', basename($path));
    }


    private function generateFields()
    {
        $fields = [];
        $foreignKeys = [];
        $createdAtField = null;
        $updatedAtField = null;
        $softDeleteField = null;

        foreach ($this->commandData->fields as $field) {
            if ($field->name == 'created_at') {
                $createdAtField = $field;
                continue;
            } elseif ($field->name == 'updated_at') {
                $updatedAtField = $field;
                continue;
            } elseif ($field->name == 'deleted_at') {
                $softDeleteField = $field;
                continue;
            }

            $fields[] = $field->migrationText;
            if (!empty($field->foreignKeyText)) {
                $foreignKeys[] = $field->foreignKeyText;
            }
        }

        if ($createdAtField and $updatedAtField) {
            $fields[] = '$table->timestamps();';
        } else {
            if ($createdAtField) {
                $fields[] = $createdAtField->migrationText;
            }
            if ($updatedAtField) {
                $fields[] = $updatedAtField->migrationText;
            }
        }

        if ($softDeleteField) {
            $fields[] = '$table->softDeletes();';
        }

        return implode(infy_nl_tab(1, 3), array_merge($fields, $foreignKeys));
    }

    public function rollback()
    {
        $fileName = 'create_'.$this->commandData->config->tableName.'_table.php';

        /** @var SplFileInfo $allFiles */
        $allFiles = File::allFiles($this->path);

        $files = [];

        foreach ($allFiles as $file) {
            $files[] = $file->getFilename();
        }

        $files = array_reverse($files);

        foreach ($files as $file) {
            if (Str::contains($file, $fileName)) {
                if ($this->rollbackFile($this->path, $file)) {
                    $this->commandData->commandComment('Migration file deleted: '.$file);
                }
                break;
            }
        }
    }
}

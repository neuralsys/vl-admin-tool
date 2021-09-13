<?php

namespace Vuongdq\VLAdminTool\Common;

use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Nullable;
use Vuongdq\VLAdminTool\Models\Field;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;

class GeneratorField
{
    /** @var string */
    public $name;
    public $dbInput;
    public $htmlInput;
    public $htmlType;
    public $fieldType;
    public $description;
    public $defaultValue;

    /** @var array */
    public $htmlValues;

    /** @var string */
    public $migrationText;
    public $foreignKeyText;
    public $validations;
    public $cssClasses;

    /** @var bool */
    public $isPrimary = false;
    public $isSearchable = true;
    public $isOrderable = true;
    public $isExportable = true;
    public $isPrintable = true;
    public $isNotNull = true;
    public $isCreatable = true;
    public $isEditable = true;
    public $isShowable = true;
    public $isForeignKey;

    /** @var $table Table  */
    public $table;

    /** @var int */
    public $numberDecimalPoints = 2;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * @param mixed $column
     * @param $dbInput
     */
    public function parseDBTypeFromModel($dbInput, $column)
    {
        $this->dbInput = $dbInput;
        if (!is_null($column)) {
            $dbConfig = $column->dbConfig;
            $this->defaultValue = $column->dbConfig->default;

            $this->dbInput = (!is_null($dbConfig->length) && $dbConfig->length > 0) ? $this->dbInput.','.$dbConfig->length : $this->dbInput;
            $this->dbInput = ($dbConfig->nullable) ? $this->dbInput.':nullable' : $this->dbInput;
            $this->dbInput = ($dbConfig->unique) ? $this->dbInput.':unique' : $this->dbInput;
            $this->dbInput = ($dbConfig->default) ? $this->dbInput.':default,'.$dbConfig->default : $this->dbInput;
        }
        $this->prepareMigrationText();
    }

    public function parseHtmlInput($htmlInput)
    {
        $this->htmlInput = $htmlInput;
        $this->htmlValues = [];

        if (empty($htmlInput)) {
            $this->htmlType = 'text';

            return;
        }

        if (Str::contains($htmlInput, 'selectTable')) {
            $inputsArr = explode(':', $htmlInput);
            $this->htmlType = array_shift($inputsArr);
            $this->htmlValues = $inputsArr;

            return;
        }

        $inputsArr = explode(',', $htmlInput);

        $this->htmlType = array_shift($inputsArr);

        if (count($inputsArr) > 0) {
            $this->htmlValues = $inputsArr;
        }
    }

    private function generateMigrationText() {
        $inputsArr = explode(':', $this->dbInput);

        $this->migrationText = '$table->';

        $fieldTypeParams = explode(',', array_shift($inputsArr));
        $this->fieldType = array_shift($fieldTypeParams);
        $this->migrationText .= $this->fieldType."('".$this->name."'";

        foreach ($fieldTypeParams as $param) {
            $this->migrationText .= ', '.$param;
        }

        $this->migrationText .= ')';

        foreach ($inputsArr as $input) {
            $inputParams = explode(',', $input);
            $functionName = array_shift($inputParams);
            $this->migrationText .= '->'.$functionName;
            $this->migrationText .= '(';
            $this->migrationText .= implode(', ', $inputParams);
            $this->migrationText .= ')';
        }

        $this->migrationText .= ';';
    }

    private function generateForeginKeyText() {
        $foreignKeys = $this->table->getForeignKeys();
        foreach ($foreignKeys as $foreignKey) {
            /** @var $foreignKey ForeignKeyConstraint */
            if (
                count($foreignKey->getLocalColumns()) != 1
                || count($foreignKey->getForeignColumns()) != 1
            ) continue;
            $localColum = $foreignKey->getLocalColumns()[0];
            if ($localColum != $this->name) continue;
            $this->isForeignKey = true;
            $foreignField = $foreignKey->getForeignColumns()[0];
            $foreignTable = $foreignKey->getForeignTableName();
            $cascadeOnUpdate = $foreignKey->onUpdate();
            $cascadeOnDelete = $foreignKey->onDelete();
            $this->foreignKeyText .= "\$table->foreign('".$this->name."')->references('".$foreignField."')->on('".$foreignTable."')";
            if (strtolower($cascadeOnUpdate) == 'cascade') {
                $this->foreignKeyText .= "->onUpdate('cascade')";
            }

            if (strtolower($cascadeOnDelete) == 'cascade') {
                $this->foreignKeyText .= "->onDelete('cascade')";
            }

            $this->foreignKeyText .= ';';
            break;
        }
    }

    private function prepareMigrationText()
    {
        $this->generateMigrationText();
        $this->generateForeginKeyText();
    }

    public function __get($key)
    {
        if ($key == 'fieldTitle') {
            return Str::title(str_replace('_', ' ', $this->name));
        } elseif ($key == 'fieldCamel') {
            return Str::camel($this->name);
        } elseif ($key == 'fieldDefaultValue') {
            if ($this->defaultValue == null) return "null";
            return "'{$this->defaultValue}'";
        }

        return $this->$key;
    }
}

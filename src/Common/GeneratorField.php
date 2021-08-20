<?php

namespace Vuongdq\VLAdminTool\Common;

use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Nullable;
use Vuongdq\VLAdminTool\Models\Field;

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

    /** @var int */
    public $numberDecimalPoints = 2;

    /**
     * @param Column $column
     * @param $dbInput
     */
    public function parseDBType($dbInput, $column = null)
    {
        $this->dbInput = $dbInput;
        if (!is_null($column)) {
            $this->dbInput = ($column->getLength() > 0) ? $this->dbInput.','.$column->getLength() : $this->dbInput;
            $this->dbInput = (!$column->getNotnull()) ? $this->dbInput.':nullable' : $this->dbInput;
        }
        $this->prepareMigrationText();
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

    private function prepareMigrationText()
    {
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
            if ($functionName == 'foreign') {
                $foreignTable = array_shift($inputParams);
                $foreignField = array_shift($inputParams);
                $this->foreignKeyText .= "\$table->foreign('".$this->name."')->references('".$foreignField."')->on('".$foreignTable."')";
                if (count($inputParams)) {
                    $cascade = array_shift($inputParams);
                    if ($cascade == 'cascade') {
                        $this->foreignKeyText .= "->onUpdate('cascade')->onDelete('cascade')";
                    }
                }
                $this->foreignKeyText .= ';';
            } else {
                $this->migrationText .= '->'.$functionName;
                $this->migrationText .= '(';
                $this->migrationText .= implode(', ', $inputParams);
                $this->migrationText .= ')';
            }
        }

        $this->migrationText .= ';';
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

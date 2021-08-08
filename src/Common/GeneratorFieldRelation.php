<?php

namespace Vuongdq\VLAdminTool\Common;

use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Models\Relation;

class GeneratorFieldRelation
{
    /** @var string */
    public $type;
    public $inputs;
    public $relationName;

    /** @var GeneratorForeignKey[] */
    public $foreignKeys = [];

    public static function parseRelation($relationInput)
    {
        $inputs = explode(',', $relationInput);

        $relation = new self();
        $relation->type = array_shift($inputs);
        $modelWithRelation = explode(':', array_shift($inputs)); //e.g ModelName:relationName
        if (count($modelWithRelation) == 2) {
            $relation->relationName = $modelWithRelation[1];
            unset($modelWithRelation[1]);
        }
        $relation->inputs = array_merge($modelWithRelation, $inputs);

        return $relation;
    }

    public static function parseRelationFromModel(Relation $relation)
    {
        $res = new self();
        $res->type = $relation->type;
        $res->inputs = [];

        $classRelation = $relation->secondField->model->class_name;
        $res->inputs[] = $classRelation;

        $firstKey = $relation->firstField->name;
        $secondKey = $relation->secondField->name;
        switch ($relation->type) {
            case "1-1i":
                $res->inputs[] = $firstKey;
                break;
            case "1-1":
                $res->inputs[] = $firstKey;
                break;
            case "1-n":
                $res->inputs[] = $secondKey;
                $res->inputs[] = $firstKey;
                break;
            case "n-1":
                $res->inputs[] = $firstKey;
                $res->inputs[] = $secondKey;
                break;
            case "m-n":
                $res->inputs[] = $relation->table_name;
                $res->inputs[] = $relation->fk_1;
                $res->inputs[] = $relation->fk_2;
                break;
        }

        return $res;
    }

    public function getRelationFunctionText($relationText = null)
    {
        $singularRelation = (!empty($this->relationName)) ? $this->relationName : Str::camel($relationText);
        $pluralRelation = (!empty($this->relationName)) ? $this->relationName : Str::camel(Str::plural($relationText));

        switch ($this->type) {
            case '1-1i':
                $functionName = $singularRelation;
                $relation = 'belongsTo';
                $relationClass = 'BelongsTo';
                break;
            case '1-1':
                $functionName = $singularRelation;
                $relation = 'hasOne';
                $relationClass = 'HasOne';
                break;
            case '1-n':
                $functionName = $pluralRelation;
                $relation = 'hasMany';
                $relationClass = 'HasMany';
                break;
            case 'n-1':
                if (!empty($this->relationName)) {
                    $singularRelation = $this->relationName;
                } elseif (isset($this->inputs[1])) {
                    $singularRelation = Str::camel(str_replace('_id', '', strtolower($this->inputs[1])));
                }
                $functionName = $singularRelation;
                $relation = 'belongsTo';
                $relationClass = 'BelongsTo';
                break;
            case 'm-n':
                $functionName = $pluralRelation;
                $relation = 'belongsToMany';
                $relationClass = 'BelongsToMany';
                break;
            case 'hmt':
                $functionName = $pluralRelation;
                $relation = 'hasManyThrough';
                $relationClass = 'HasManyThrough';
                break;
            default:
                $functionName = '';
                $relation = '';
                $relationClass = '';
                break;
        }

        if (!empty($functionName) and !empty($relation)) {
            return $this->generateRelation($functionName, $relation, $relationClass);
        }

        return '';
    }

    private function generateRelation($functionName, $relation, $relationClass)
    {
        $inputs = $this->inputs;
        $modelName = array_shift($inputs);

        $template = get_template('model.relationship', 'vl-admin-tool');

        $template = str_replace('$RELATIONSHIP_CLASS$', $relationClass, $template);
        $template = str_replace('$FUNCTION_NAME$', $functionName, $template);
        $template = str_replace('$RELATION$', $relation, $template);
        $template = str_replace('$RELATION_MODEL_NAME$', $modelName, $template);

        if (count($inputs) > 0) {
            $inputFields = implode("', '", $inputs);
            $inputFields = ", '".$inputFields."'";
        } else {
            $inputFields = '';
        }

        $template = str_replace('$INPUT_FIELDS$', $inputFields, $template);

        return $template;
    }
}

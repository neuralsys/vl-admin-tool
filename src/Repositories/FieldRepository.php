<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Field;
use Vuongdq\VLAdminTool\Repositories\BaseRepository;

/**
 * Class FieldRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:18 am UTC
*/

class FieldRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Field::class;
    }

    public function getFieldsForRelation($exceptId) {
        $fields = $this
            ->model
            ->with('model')
            ->where('id', '<>', $exceptId)
            ->orderBy('model_id')
            ->orderBy('id')
            ->get();

        $res = [];
        foreach ($fields as $field) {
            $res[(string)$field->id] = $field->model->table_name . "." . $field->name;
        }

        return $res;
    }
}

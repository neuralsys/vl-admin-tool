<?php

namespace Vuongdq\VLAdminTool\Repositories;

use App\Models\Field;
use App\Repositories\BaseRepository;

/**
 * Class FieldRepository
 * @package App\Repositories
 * @version November 27, 2020, 9:14 am UTC
*/

class FieldRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'model_id',
        'name',
        'db_type',
        'html_type',
        'primary',
        'unique',
        'auto_increment',
        'nullable',
        'creatable',
        'editable'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Field::class;
    }
}

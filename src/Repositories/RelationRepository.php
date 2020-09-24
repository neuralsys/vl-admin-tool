<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Relation;

/**
 * Class RelationRepository
 * @package App\Repositories
 * @version September 18, 2020, 11:19 am +07
*/

class RelationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'first_model_id',
        'first_foreign_key',
        'second_model_id',
        'second_foreign_key',
        'table_name',
        'first_key',
        'second_key'
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
     * Configure the Models
     **/
    public function model()
    {
        return Relation::class;
    }
}

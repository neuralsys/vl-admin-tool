<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Model;

/**
 * Class ModelRepository
 * @package App\Repositories
 * @version September 18, 2020, 11:16 am +07
*/

class ModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'class_name',
        'table_name',
        'description',
        'timestamps',
        'soft_delete',
        'test',
        'swagger',
        'datatables',
        'paginate'
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
        return Model::class;
    }
}

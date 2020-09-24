<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Menu;

/**
 * Class MenuRepository
 * @package App\Repositories
 * @version September 18, 2020, 11:31 am +07
*/

class MenuRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'url_pattern',
        'index_url',
        'title',
        'parent_id'
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
        return Menu::class;
    }
}

<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Illuminate\Support\Facades\DB;
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

    public function insertAdminMenu($force = false) {
        DB::beginTransaction();
        try {
            $rootMenu = $this->create([
                'title' => 'Admin Tool',
                'type' => 'has-child',
                'pos' => 9999,
            ]);

            $modelMenu = $this->create([
                'url_pattern' => 'models*',
                'type' => 'no-child',
                'index_route_name' => 'models.index',
                'title' => 'Model',
                'parent_id' => $rootMenu->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

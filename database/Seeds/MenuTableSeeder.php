<?php

namespace Vuongdq\VLAdminTool\Database\Seeds;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Vuongdq\VLAdminTool\Models\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database Seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $rootMenu = Menu::create([
                'title' => 'Admin Tool',
                'type' => 'has-child',
                'pos' => 9999,
            ]);

            $modelMenu = Menu::create([
                'url_pattern' => 'models*',
                'type' => 'no-child',
                'index_route_name' => 'models.index',
                'title' => 'Model',
                'parent_id' => $rootMenu->id
            ]);

            $menuMenu = Menu::create([
                'url_pattern' => 'menu*',
                'type' => 'no-child',
                'index_route_name' => 'menus.index',
                'title' => 'Menu',
                'parent_id' => $rootMenu->id
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

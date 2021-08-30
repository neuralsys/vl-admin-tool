<?php

namespace Vuongdq\VLAdminTool\Generators\Scaffold;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Generators\BaseGenerator;
use Vuongdq\VLAdminTool\Repositories\MenuRepository;
use Illuminate\Support\Facades\Artisan;

class MenuGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
    }

    public function generate()
    {
        DB::beginTransaction();
        $parentId = 0;
        $menuRepo = app(MenuRepository::class);
        try {
            $modelMenu = $menuRepo->create([
                'url_pattern' => fill_template($this->commandData->dynamicVars,'$MODEL_NAME_PLURAL_DASHED$*'),
                'type' => 'no-child',
                'index_route_name' => fill_template($this->commandData->dynamicVars,'$MODEL_NAME_PLURAL_DASHED$.index'),
                'title' => fill_template($this->commandData->dynamicVars,'$MODEL_NAME$'),
                'parent_id' => $parentId
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->commandData->commandObj->info('Menu '.$this->commandData->config->mHumanPlural.' is already exists, Skipping Adjustment.');
            $this->commandData->commandError($e->getMessage());
        }

        $this->commandData->commandComment("\n".$this->commandData->config->mCamelPlural.' menu added.');
        Artisan::call('vlat.generate:menu', []);
    }

    public function rollback()
    {
        $parentId = 0;
        $menuRepo = app(MenuRepository::class);

        $modelMenu = $menuRepo->where(
            'url_pattern',
            fill_template($this->commandData->dynamicVars,'$MODEL_NAME_PLURAL_DASHED$*')
        )->first();

        if (!empty($modelMenu)) {
            foreach ($modelMenu->children as $childMenu) {
                $childMenu->parentId = 0;
                $childMenu->save();
            }

            $modelMenu->delete();
        }
    }
}

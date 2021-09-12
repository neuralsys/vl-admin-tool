<?php

namespace Vuongdq\VLAdminTool\Commands\Menu;

use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Vuongdq\VLAdminTool\Commands\BaseCommand;
use Vuongdq\VLAdminTool\Models\Menu;
use Vuongdq\VLAdminTool\Repositories\MenuRepository;

class GenerateMenuCommand extends BaseCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vlat.generate:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate VL Admin Tool';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $this->info('Generating VL Admin Tool Menu...');
        $menuRepo = app(MenuRepository::class);
        $menus = $menuRepo->where('parent_id', 0)->orderBy('pos')->get();
        $result = '';
        foreach ($menus as $menu)
            $result = $result . PHP_EOL . $this->generateMenu($menu, 1);

        $menuPath = resource_path('views/layouts/menu.blade.php');
        file_put_contents($menuPath, $result);
        $this->info('Generate VL Admin Tool successfully!');
        return 0;
    }

    public function getOptions() {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force install'],
        ];
    }

    public function getArguments() {
        return [];
    }

    public function generateMenu(Menu $menu, $level) {
        $result = '';
        $templateMenu = get_template('menu/'.$menu->type, 'vl-admin-tool');
        $variables = array_merge(
            $this->getVariables($menu, $level),
            $this->commandData->dynamicVars
        );
        $variables['$TABS$'] = infy_tabs(($level - 1) * 2);
        if ($menu->id == 1) {
            $variables['$VISIBLE_CONDITION_START$'] = "@if(\App\Http\Middleware\CheckPermission::hasRole(\Illuminate\Support\Facades\Auth::user(), [\App\Models\Role::SUPER_ADMIN]))";
            $variables['$VISIBLE_CONDITION_END$'] = "@endif";
        }

        return fill_template($variables, $templateMenu);
    }

    public function getVariables($menu, $level) {
        switch ($menu->type) {
            case 'header':
                return [
                    '$MENU_TITLE$' => $menu->title
                ];
                break;
            case 'no-child':
                return [
                    '$MENU_TITLE$' => $menu->title,
                    '$INDEX_ROUTE$' => $menu->index_route_name ? "{{route('$menu->index_route_name')}}" : '#',
                    '$URL_PATTERN$' => $menu->url_pattern,
                    '$PADDING_LEFT$' => 1 + 0.8 * ($level - 1),
                    '$ICON_CLASS$' => 'fas fa-circle nav-icon'
                ];
                break;
            case 'has-child':
                $childrenMenus = $menu->children()->orderBy('pos')->get();
                $menus = '';
                $condition = '';
                foreach ($childrenMenus as $childrenMenu) {
                    if ($condition == '') $condition = "Request::is('$childrenMenu->url_pattern')";
                    else $condition = $condition . ' | ' . "Request::is('$childrenMenu->url_pattern')";
                    $menuObj = $this->generateMenu($childrenMenu, $level + 1);
                    $menus = $menus.PHP_EOL.$menuObj;
                }

                return [
                    '$MENU_TITLE$' => $menu->title,
                    '$CONDITION$' => $condition == "" ? "false" : $condition,
                    '$INDEX_ROUTE$' => $menu->index_route_name ? "{{route('$menu->index_route_name')}}" : '#',
                    '$CHILDRENT_MENUS$' => $menus,
                    '$PADDING_LEFT$' => 1 + 0.8 * ($level - 1),
                    '$ICON_CLASS$' => 'fas fa-circle nav-icon'
                ];
                break;
        }
    }
}

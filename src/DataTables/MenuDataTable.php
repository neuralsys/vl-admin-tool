<?php

namespace Vuongdq\VLAdminTool\DataTables;

use Vuongdq\VLAdminTool\Models\Menu;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class MenuDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query) {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'vl-admin-tool::menus.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Menu $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Menu $model) {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title' => __('crud.action')])
            ->parameters([
                'dom' => '<"menu-toolbar">Bfrtip',
                'order' => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, menuSelectedRows);
                 }",
                'buttons' => [
                    [
                        'extend' => 'export',
                        'className' => 'btn btn-default btn-sm no-corner',
                        'text' => '<i class="fa fa-download"></i> ' . __('auth.app.export') . ''
                    ],
                    [
                        'extend' => 'reload',
                        'className' => 'btn btn-default btn-sm no-corner',
                        'text' => '<i class="fa fa-refresh"></i> ' . __('auth.app.reload') . ''
                    ],
                ],
                'language' => [
                    'url' => url('//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json'),
                ],
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'select' => true
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns() {
        return [
            'type' => new Column(['title' => __('vl-admin-tool-lang::models/menu.fields.type'), 'data' => 'type'])
            ,
            'url_pattern' => new Column(['title' => __('vl-admin-tool-lang::models/menu.fields.url_pattern'), 'data' => 'url_pattern'])
            ,
            'index_route_name' => new Column(['title' => __('vl-admin-tool-lang::models/menu.fields.index_route_name'), 'data' => 'index_route_name'])
            ,
            'title' => new Column(['title' => __('vl-admin-tool-lang::models/menu.fields.title'), 'data' => 'title'])
            ,
            'parent_id' => new Column(['title' => __('vl-admin-tool-lang::models/menu.fields.parent_id'), 'data' => 'parent_id'])
            ,
            'pos' => new Column(['title' => __('vl-admin-tool-lang::models/menu.fields.pos'), 'data' => 'pos'])

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'menus_datatable_' . time();
    }
}

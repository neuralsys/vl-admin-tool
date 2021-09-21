<?php

namespace App\DataTables;

use App\Models\Permission;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class PermissionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Permission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Permission $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax('', $this->getScript(), [], ['error' => 'function (err) { defaultOnError(err);}'])
            ->parameters([
                'dom'       => '<"permission-toolbar">Bfrtip',
                'order'     => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, permissionSelectedRows);
                 }",
                'buttons'   => [
                    [
                       'extend' => 'export',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-download"></i> ' .__('auth.app.export').''
                    ],
                    [
                       'extend' => 'reload',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-refresh"></i> ' .__('auth.app.reload').''
                    ],
                ],
                 'language' => __('vl-admin-tool-lang::datatable'),
                 "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                 'select' => true
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name' => (new Column([
                'title' => __('models/permission.fields.name'),
                'data' => 'name',
                'searchable' => true,
                'orderable' => false,
                'exportable' => true,
                'printable' => true,
                'attributes' => [
                    'class' => ''
                ],
            ])),
            'href' => (new Column([
                'title' => __('models/permission.fields.href'),
                'data' => 'href',
                'searchable' => true,
                'orderable' => false,
                'exportable' => true,
                'printable' => true,
                'attributes' => [
                    'class' => ''
                ],
            ])),
            'category' => (new Column([
                'title' => __('models/permission.fields.category'),
                'data' => 'category',
                'searchable' => true,
                'orderable' => false,
                'exportable' => true,
                'printable' => true,
                'attributes' => [
                    'class' => ''
                ],
            ]))
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'permissions_datatable_' . time();
    }

    private function getScript()
    {
        return "
        ";
    }
}

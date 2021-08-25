<?php

namespace App\DataTables;

use App\Models\RolePermission;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class RolePermissionDataTable extends DataTable
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

        return $dataTable
            ->filterColumn("permission_name", function ($query, $keyword) {
                return $query->where('p.name', 'like', "%$keyword%");
            })
            ->filterColumn("permission_href", function ($query, $keyword) {
                return $query->where('p.href', 'like', "%$keyword%");
            })
            ->addColumn('action', 'role_permissions.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RolePermission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RolePermission $model)
    {
        $roleId = $this->request->input('role_id');
        if ($roleId == null) $roleId = 0;

        $query = $model
            ->newQuery()
            ->select('role_permissions.*');

        $query->where('role_id', $roleId);

        $query->join('permissions as p', 'p.id', 'role_permissions.permission_id')
            ->addSelect('p.name as permission_name')
            ->addSelect('p.href as permission_href');

        return $query;
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
            ->addAction(['width' => '120px', 'printable' => false, 'title' => __('crud.action')])
            ->parameters([
                'dom'       => '<"rolePermission-toolbar">Bfrtip',
                'order'     => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, rolePermissionSelectedRows);
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
            "role_id" => (new Column([
                'title' => __('models/role.singular'),
                'data' => 'role_id',
                'searchable' => true,
                'orderable' => true,
                'exportable' => false,
                'printable' => false,
                'visible' => false,
                'attributes' => [
                    'class' => ''
                ],
            ])),
            "permission_id" => (new Column([
                'title' => __('models/permission.singular'),
                'data' => 'permission_id',
                'searchable' => true,
                'orderable' => true,
                'exportable' => false,
                'printable' => false,
                'visible' => false,
                'attributes' => [
                    'class' => ''
                ],
            ])),
            "permission_name" => (new Column([
                'title' => __('models/permission.singular'),
                'data' => 'permission_name',
                'searchable' => true,
                'orderable' => true,
                'exportable' => false,
                'printable' => false,
                'attributes' => [
                    'class' => ''
                ],
            ])),
            "permission_href" => (new Column([
                'title' => __('models/permission.fields.href'),
                'data' => 'permission_href',
                'searchable' => true,
                'orderable' => true,
                'exportable' => false,
                'printable' => false,
                'attributes' => [
                    'class' => ''
                ],
            ])),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'role_permissions_datatable_' . time();
    }

    private function getScript()
    {
        return "
        ";
    }
}

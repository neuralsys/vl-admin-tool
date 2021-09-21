<?php

namespace App\DataTables;

use App\Models\UserRole;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class UserRoleDataTable extends DataTable
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
            ->filterColumn("user_email", function ($query, $keyword) {
                return $query->where('u.email', 'like', "%$keyword%");
            })
            ->filterColumn("role_title", function ($query, $keyword) {
                return $query->where('r.title', 'like', "%$keyword%");
            })
            ->addColumn('action', 'user_roles.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\UserRole $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(UserRole $model)
    {
        return $model
            ->newQuery()
            ->select('user_roles.*')
            ->leftJoin('users as u', 'u.id', 'user_roles.user_id')
            ->leftJoin('roles as r', 'r.id', 'user_roles.role_id')
            ->addSelect('u.email as user_email')
            ->addSelect('r.title as role_title');
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
                'dom'       => '<"userRole-toolbar">Bfrtip',
                'order'     => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, userRoleSelectedRows);
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
            'user' => (new Column([
                'title' => __('models/user.singular'),
                'data' => 'user_email',
                'searchable' => true,
                'orderable' => true,
                'exportable' => false,
                'printable' => false,
                'attributes' => [
                    'class' => ''
                ],
            ])),
            'role' => (new Column([
                'title' => __('models/role.singular'),
                'data' => 'role_title',
                'searchable' => true,
                'orderable' => true,
                'exportable' => false,
                'printable' => false,
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
        return 'user_roles_datatable_' . time();
    }

    private function getScript()
    {
        return "
        ";
    }
}

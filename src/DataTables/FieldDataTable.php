<?php

namespace Vuongdq\VLAdminTool\DataTables;

use Vuongdq\VLAdminTool\Models\Field;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class FieldDataTable extends DataTable
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
            ->addColumn('db_config_view', 'vl-admin-tool::fields.datatable_action_columns.db_config_column')
            ->addColumn('dt_config_view', 'vl-admin-tool::fields.datatable_action_columns.dt_config_column')
            ->addColumn('crud_config_view', 'vl-admin-tool::fields.datatable_action_columns.crud_config_column')
            ->addColumn('action', 'vl-admin-tool::fields.datatables_actions')
            ->rawColumns(['db_config_view', 'action', 'dt_config_view', 'crud_config_view']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Field $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Field $model)
    {
        $modelId = $this->request->input('model_id');
        return $model->newQuery()->where('model_id', $modelId);
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
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title' => __('crud.action')])
            ->parameters([
                'dom'       => '<"field-toolbar">Bfrtip',
                'order'     => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, fieldSelectedRows);
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
    protected function getColumns()
    {
        return [
            'name' => new Column(['title' => __('vl-admin-tool-lang::models/field.fields.name'), 'data' => 'name']),
            'html_type' => new Column(['title' => __('vl-admin-tool-lang::models/field.fields.html_type'), 'data' => 'html_type']),
            'db_config' => new Column(['title' => __('vl-admin-tool-lang::models/dBConfig.plural'), 'data' => 'db_config_view']),
            'dt_config' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.plural'), 'data' => 'dt_config_view']),
            'crud_config' => new Column(['title' => __('vl-admin-tool-lang::models/cRUDConfig.plural'), 'data' => 'crud_config_view']),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'fields_datatable_' . time();
    }
}

<?php

namespace Vuongdq\VLAdminTool\DataTables;

use Vuongdq\VLAdminTool\Models\Model;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ModelDataTable extends DataTable
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
            ->addColumn('field_view', 'vl-admin-tool::models.datatable_action_columns.field_column')
            ->addColumn('action', 'vl-admin-tool::models.datatables_actions')
            ->rawColumns(['field_view', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Model $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Model $model)
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
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title' => __('crud.action')])
            ->parameters([
                'dom'       => '<"model-toolbar">Bfrtip',
                'order'     => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, modelSelectedRows);
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
            'class_name' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.class_name'), 'data' => 'class_name']),
            'table_name' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.table_name'), 'data' => 'table_name']),
            'singular' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.singular'), 'data' => 'singular']),
            'plural' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.plural'), 'data' => 'plural']),
            'description' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.description'), 'data' => 'description']),
            'use_timestamps' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.timestamps'), 'data' => 'use_timestamps']),
            'use_soft_delete' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.soft_delete'), 'data' => 'use_soft_delete']),
            'fields' => new Column(['title' => __('vl-admin-tool-lang::models/field.plural'), 'data' => 'field_view'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'models_datatable_' . time();
    }
}

<?php

namespace Vuongdq\VLAdminTool\DataTables;

use Vuongdq\VLAdminTool\Models\Field;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class FieldDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query) {
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
    public function query(Field $model) {
        $modelId = $this->request->input('model_id');
        return $model
            ->newQuery()
            ->where('model_id', $modelId)
            ->with('dbConfig', 'dtConfig', 'crudConfig');
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
                'dom' => '<"field-toolbar">Bfrtip',
                'order' => [[0, 'asc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, fieldSelectedRows);
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
            'id' => new Column([
                'title' => __('vl-admin-tool-lang::models/field.fields.id'),
                'data' => 'id',
                'searchable' => false
            ]),
            'name' => new Column(['title' => __('vl-admin-tool-lang::models/field.fields.name'), 'data' => 'name']),
            'html_type' => new Column(['title' => __('vl-admin-tool-lang::models/field.fields.html_type'), 'data' => 'html_type', 'searchable' => false, 'orderable' => false]),
//            'db_config' => new Column(['title' => __('vl-admin-tool-lang::models/dBConfig.plural'), 'data' => 'db_config_view']),
            'type' => new Column(['title' => __('vl-admin-tool-lang::models/dBConfig.fields.type'), 'data' => 'db_config.type', 'searchable' => false, 'orderable' => false]),
            'length' => new Column(['title' => __('vl-admin-tool-lang::models/dBConfig.fields.length'), 'data' => 'db_config.length', 'searchable' => false, 'orderable' => false]),
            'nullable' => new Column(['title' => __('vl-admin-tool-lang::models/dBConfig.fields.nullable'), 'data' => 'db_config.nullable', 'searchable' => false, 'orderable' => false]),
            'unique' => new Column(['title' => __('vl-admin-tool-lang::models/dBConfig.fields.unique'), 'data' => 'db_config.unique', 'searchable' => false, 'orderable' => false]),
            'default' => new Column(['title' => __('vl-admin-tool-lang::models/dBConfig.fields.default'), 'data' => 'db_config.default', 'searchable' => false, 'orderable' => false]),

//            'dt_config' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.plural'), 'data' => 'dt_config_view']),
            'showable' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.fields.showable'), 'data' => 'dt_config.showable', 'searchable' => false, 'orderable' => false]),
            'searchable' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.fields.searchable'), 'data' => 'dt_config.searchable', 'searchable' => false, 'orderable' => false]),
            'orderable' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.fields.orderable'), 'data' => 'dt_config.orderable', 'searchable' => false, 'orderable' => false]),
            'exportable' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.fields.exportable'), 'data' => 'dt_config.exportable', 'searchable' => false, 'orderable' => false]),
            'printable' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.fields.printable'), 'data' => 'dt_config.printable', 'searchable' => false, 'orderable' => false]),
            'class' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.fields.class'), 'data' => 'dt_config.class', 'searchable' => false, 'orderable' => false]),
            'has_footer' => new Column(['title' => __('vl-admin-tool-lang::models/dTConfig.fields.has_footer'), 'data' => 'dt_config.has_footer', 'searchable' => false, 'orderable' => false]),

//            'crud_config' => new Column(['title' => __('vl-admin-tool-lang::models/cRUDConfig.plural'), 'data' => 'crud_config_view']),
            'creatable' => new Column(['title' => __('vl-admin-tool-lang::models/cRUDConfig.fields.creatable'), 'data' => 'crud_config.creatable', 'searchable' => false, 'orderable' => false]),
            'editable' => new Column(['title' => __('vl-admin-tool-lang::models/cRUDConfig.fields.editable'), 'data' => 'crud_config.editable', 'searchable' => false, 'orderable' => false]),
            'rules' => new Column(['title' => __('vl-admin-tool-lang::models/cRUDConfig.fields.rules'), 'data' => 'crud_config.rules', 'searchable' => false, 'orderable' => false]),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'fields_datatable_' . time();
    }
}

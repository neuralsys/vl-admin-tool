<?php

namespace Vuongdq\VLAdminTool\DataTables;

use Vuongdq\VLAdminTool\Models\Relation;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class RelationDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query) {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('second_field_name', function ($record) {
                return $record->secondField->name;
            })
            ->addColumn('second_field_table', function ($record) {
                return $record->secondField->model->table_name;
            })
            ->addColumn('action', 'vl-admin-tool::relations.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Relation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Relation $model) {
        $fieldId = $this->request->input('field_id');

        return $model
            ->newQuery()
            ->where('first_field_id', $fieldId);
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
                'dom' => '<"relation-toolbar">Bfrtip',
                'order' => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, relationSelectedRows);
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
            'second_field_id' => new Column(['title' => __('vl-admin-tool-lang::models/relation.fields.second_field_id'), 'data' => 'second_field_id']),
            'second_field_table' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.table_name'), 'data' => 'second_field_table']),
            'second_field_name' => new Column(['title' => __('vl-admin-tool-lang::models/field.fields.name'), 'data' => 'second_field_name']),
            'type' => new Column(['title' => __('vl-admin-tool-lang::models/relation.fields.type'), 'data' => 'type']),
            'table_name' => new Column(['title' => __('vl-admin-tool-lang::models/relation.fields.table_name'), 'data' => 'table_name']),
            'fk_1' => new Column(['title' => __('vl-admin-tool-lang::models/relation.fields.fk_1'), 'data' => 'fk_1']),
            'fk_2' => new Column(['title' => __('vl-admin-tool-lang::models/relation.fields.fk_2'), 'data' => 'fk_2']),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'relations_datatable_' . time();
    }
}

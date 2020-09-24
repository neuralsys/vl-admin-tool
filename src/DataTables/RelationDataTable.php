<?php

namespace Vuongdq\VLAdminTool\DataTables;

use Vuongdq\VLAdminTool\Models\Relation;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class RelationDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'relations.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Relation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Relation $model)
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
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    [
                       'extend' => 'create',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-plus"></i> ' .__('auth.app.create').''
                    ],
                    [
                       'extend' => 'export',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-download"></i> ' .__('auth.app.export').''
                    ],
                    [
                       'extend' => 'print',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-print"></i> ' .__('auth.app.print').''
                    ],
                    [
                       'extend' => 'reset',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-undo"></i> ' .__('auth.app.reset').''
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
            'type' => new Column(['title' => __('models/relations.fields.type'), 'data' => 'type']),
            'first_model_id' => new Column(['title' => __('models/relations.fields.first_model_id'), 'data' => 'first_model_id']),
            'first_foreign_key' => new Column(['title' => __('models/relations.fields.first_foreign_key'), 'data' => 'first_foreign_key']),
            'second_model_id' => new Column(['title' => __('models/relations.fields.second_model_id'), 'data' => 'second_model_id']),
            'second_foreign_key' => new Column(['title' => __('models/relations.fields.second_foreign_key'), 'data' => 'second_foreign_key']),
            'table_name' => new Column(['title' => __('models/relations.fields.table_name'), 'data' => 'table_name']),
            'first_key' => new Column(['title' => __('models/relations.fields.first_key'), 'data' => 'first_key']),
            'second_key' => new Column(['title' => __('models/relations.fields.second_key'), 'data' => 'second_key'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'relations_datatable_' . time();
    }
}

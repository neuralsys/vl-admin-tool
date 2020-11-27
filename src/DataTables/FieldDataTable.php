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

        return $dataTable->addColumn('action', 'fields.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Field $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Field $model)
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
            'model_id' => new Column(['title' => __('models/fields.fields.model_id'), 'data' => 'model_id']),
            'name' => new Column(['title' => __('models/fields.fields.name'), 'data' => 'name']),
            'db_type' => new Column(['title' => __('models/fields.fields.db_type'), 'data' => 'db_type']),
            'html_type' => new Column(['title' => __('models/fields.fields.html_type'), 'data' => 'html_type']),
            'primary' => new Column(['title' => __('models/fields.fields.primary'), 'data' => 'primary']),
            'unique' => new Column(['title' => __('models/fields.fields.unique'), 'data' => 'unique']),
            'auto_increment' => new Column(['title' => __('models/fields.fields.auto_increment'), 'data' => 'auto_increment']),
            'nullable' => new Column(['title' => __('models/fields.fields.nullable'), 'data' => 'nullable']),
            'creatable' => new Column(['title' => __('models/fields.fields.creatable'), 'data' => 'creatable']),
            'editable' => new Column(['title' => __('models/fields.fields.editable'), 'data' => 'editable'])
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

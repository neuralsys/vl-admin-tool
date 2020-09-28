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

        return $dataTable->addColumn('action', 'vl-admin-tool::models.datatables_actions');
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
            'class_name' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.class_name'), 'data' => 'class_name']),
            'table_name' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.table_name'), 'data' => 'table_name']),
            'description' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.description'), 'data' => 'description']),
            'timestamps' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.timestamps'), 'data' => 'timestamps']),
            'soft_delete' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.soft_delete'), 'data' => 'soft_delete']),
            'test' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.test'), 'data' => 'test']),
            'swagger' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.swagger'), 'data' => 'swagger']),
            'datatables' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.datatables'), 'data' => 'datatables']),
            'paginate' => new Column(['title' => __('vl-admin-tool-lang::models/model.fields.paginate'), 'data' => 'paginate'])
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

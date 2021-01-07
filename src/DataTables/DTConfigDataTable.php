<?php

namespace Vuongdq\VLAdminTool\DataTables;

use Vuongdq\VLAdminTool\Models\DTConfig;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class DTConfigDataTable extends DataTable
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
            ->addColumn('action', 'd_t_configs.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DTConfig $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DTConfig $model)
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
                'dom'       => '<"dTConfig-toolbar">Bfrtip',
                'order'     => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, dTConfigSelectedRows);
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
            'field_id' => new Column(['title' => __('models/dTConfigs.fields.field_id'), 'data' => 'field_id']),
            'showable' => new Column(['title' => __('models/dTConfigs.fields.showable'), 'data' => 'showable']),
            'searchable' => new Column(['title' => __('models/dTConfigs.fields.searchable'), 'data' => 'searchable']),
            'orderable' => new Column(['title' => __('models/dTConfigs.fields.orderable'), 'data' => 'orderable']),
            'exportable' => new Column(['title' => __('models/dTConfigs.fields.exportable'), 'data' => 'exportable']),
            'printable' => new Column(['title' => __('models/dTConfigs.fields.printable'), 'data' => 'printable']),
            'class' => new Column(['title' => __('models/dTConfigs.fields.class'), 'data' => 'class']),
            'has_footer' => new Column(['title' => __('models/dTConfigs.fields.has_footer'), 'data' => 'has_footer'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'd_t_configs_datatable_' . time();
    }
}

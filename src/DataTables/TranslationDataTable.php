<?php

namespace Vuongdq\VLAdminTool\DataTables;

use Vuongdq\VLAdminTool\Models\Translation;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class TranslationDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query) {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'vl-admin-tool::translations.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Translation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Translation $model) {
        return $model->newQuery();
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
                'dom' => '<"translation-toolbar">Bfrtip',
                'order' => [[0, 'desc']],
                'rowCallback' => "function( nRow, aData, iDisplayIndex ) {
                    fnRowCallBack(nRow, aData, iDisplayIndex, translationSelectedRows);
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
            'file_id' => new Column(['title' => __('vl-admin-tool-lang::models/translation.fields.file_id'), 'data' => 'file_id'])
            ,
            'lang_id' => new Column(['title' => __('vl-admin-tool-lang::models/translation.fields.lang_id'), 'data' => 'lang_id'])
            ,
            'key' => new Column(['title' => __('vl-admin-tool-lang::models/translation.fields.key'), 'data' => 'key'])
            ,
            'value' => new Column(['title' => __('vl-admin-tool-lang::models/translation.fields.value'), 'data' => 'value'])

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'translations_datatable_' . time();
    }
}

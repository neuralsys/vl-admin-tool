@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover myDataTable', 'id' => 'translation-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::translations.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var translationSelectedRows = [];
        var translationTable = $('#translation-datatable').DataTable();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            initDatatableEvent('#translation-datatable', translationSelectedRows);
        });
    </script>
@endpush

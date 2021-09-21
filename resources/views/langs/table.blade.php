@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover myDataTable', 'id' => 'lang-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::langs.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var langSelectedRows = [];
        var langTable = $('#lang-datatable').DataTable();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            initDatatableEvent('#lang-datatable', langSelectedRows);
        });
    </script>
@endpush

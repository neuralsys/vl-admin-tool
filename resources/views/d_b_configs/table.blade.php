@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover myDataTable', 'id' => 'dBConfig-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::d_b_configs.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var dBConfigSelectedRows = [];
        var dBConfigTable = $('#dBConfig-datatable').DataTable();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            initDatatableEvent('#dBConfig-datatable', dBConfigSelectedRows);
        });
    </script>
@endpush

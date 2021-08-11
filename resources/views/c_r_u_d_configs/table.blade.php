@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover myDataTable', 'id' => 'cRUDConfig-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::c_r_u_d_configs.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var cRUDConfigSelectedRows = [];
        var cRUDConfigTable = null;
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            cRUDConfigTable = $('#cRUDConfig-datatable').DataTable();
            initDatatableEvent('#cRUDConfig-datatable', cRUDConfigSelectedRows);
        });
    </script>
@endpush

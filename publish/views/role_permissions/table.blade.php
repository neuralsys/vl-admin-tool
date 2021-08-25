@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!!
            $dataTable->table([
                'width' => '100%',
                'class' => 'table table-bordered table-hover dataTable',
                'id' => 'rolePermission-datatable',
                'style' => 'border-collapse: collapse !important;'
            ])
        !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('role_permissions.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var rolePermissionSelectedRows = [];
        var rolePermissionTable = null;
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            rolePermissionTable = window.LaravelDataTables["rolePermission-datatable"];
            initDatatableEvent('#rolePermission-datatable', rolePermissionSelectedRows);
        });
    </script>
@endpush

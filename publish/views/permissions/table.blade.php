@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!!
            $dataTable->table([
                'width' => '100%',
                'class' => 'table table-bordered table-hover dataTable',
                'id' => 'permission-datatable',
                'style' => 'border-collapse: collapse !important;'
            ])
        !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('permissions.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var permissionSelectedRows = [];
        var permissionTable = null;
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            permissionTable = window.LaravelDataTables["permission-datatable"];
            initDatatableEvent('#permission-datatable', permissionSelectedRows);
        });
    </script>
@endpush

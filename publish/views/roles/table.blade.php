@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!!
            $dataTable->table([
                'width' => '100%',
                'class' => 'table table-bordered table-hover dataTable',
                'id' => 'role-datatable',
                'style' => 'border-collapse: collapse !important;'
            ])
        !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('roles.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var roleSelectedRows = [];
        var roleTable = null;
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            roleTable = window.LaravelDataTables["role-datatable"];
            initDatatableEvent('#role-datatable', roleSelectedRows);
        });
    </script>
@endpush

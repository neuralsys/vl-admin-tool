@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!!
            $dataTable->table([
                'width' => '100%',
                'class' => 'table table-bordered table-hover dataTable',
                'id' => 'userRole-datatable',
                'style' => 'border-collapse: collapse !important;'
            ])
        !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('user_roles.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var userRoleSelectedRows = [];
        var userRoleTable = null;
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            userRoleTable = window.LaravelDataTables["userRole-datatable"];
            initDatatableEvent('#userRole-datatable', userRoleSelectedRows);
        });
    </script>
@endpush

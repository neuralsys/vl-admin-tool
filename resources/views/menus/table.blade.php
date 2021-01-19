@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover dataTable', 'id' => 'menu-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::menus.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var menuSelectedRows = [];
        var menuTable = null;
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            menuTable = $('#menu-datatable').DataTable();
            initDatatableEvent('#menu-datatable', menuSelectedRows);
        });
    </script>
@endpush

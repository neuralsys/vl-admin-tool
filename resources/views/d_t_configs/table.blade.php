@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover dataTable', 'id' => 'dTConfig-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('dTConfigs.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var dTConfigSelectedRows = [];
        var dTConfigTable = $('#dTConfig-datatable').DataTable();
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            initDatatableEvent('#dTConfig-datatable', dTConfigSelectedRows);
        });
    </script>
@endpush

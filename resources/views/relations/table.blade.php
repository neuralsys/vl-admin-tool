@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover myDataTable', 'id' => 'relation-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::relations.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var relationSelectedRows = [];
        var relationTable = null;
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            relationTable = $('#relation-datatable').DataTable();
            initDatatableEvent('#relation-datatable', relationSelectedRows);
        });
    </script>
@endpush

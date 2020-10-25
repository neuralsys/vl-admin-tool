@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover dataTable', 'id' => 'model-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::models.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var modelSelectedRows = [];
        var modelTable = $('#model-datatable').DataTable();
        var modelCreateModal = $('#model-create-modal');
        var modelCreateForm = $('#model-create-modal #model-create-form');
        var modelEditModal = $('#model-edit-modal');
        var modelEditForm = $('#model-edit-modal #model-edit-form');
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            initDatatableEvent('#model-datatable', modelSelectedRows);
        });
    </script>
@endpush

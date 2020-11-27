@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover dataTable', 'id' => 'field-datatable']) !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::fields.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var fieldSelectedRows = [];
        var fieldTable = $('#field-datatable').DataTable();
        var fieldCreateModal = $('#field-create-modal');
        var fieldCreateForm = $('#field-create-modal #field-create-form');
        var fieldEditModal = $('#field-edit-modal');
        var fieldEditForm = $('#field-edit-modal #field-edit-form');
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            initDatatableEvent('#field-datatable', fieldSelectedRows);
        });
    </script>
@endpush

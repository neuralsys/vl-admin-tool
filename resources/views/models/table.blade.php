@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!!
            $dataTable->table([
                'width' => '100%',
                'class' => 'table table-bordered table-hover dataTable',
                'id' => 'model-datatable',
                'style' => 'border-collapse: collapse !important;'
            ])
        !!}
    </div>
</div>

@push('scripts')
    @include('layouts.datatables_js')
    @include('vl-admin-tool::models.toolbar_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var modelSelectedRows = [];
        var modelTable = null;
    </script>

    <script type="text/javascript">
        const showGenerateModal = (ele) => {
            let table = $(ele).closest('table').DataTable();
            let row = $(ele).closest('tr');
            let data = table.row(row).data();
            let templateAction = modelGenerateForm.data('templateAction');
            modelGenerateForm.attr('action', templateAction.format(data.id));

            resetForm(modelGenerateModal);
            modelGenerateModal.modal('show');
        }

        $(document).ready(function() {
            modelTable = $("#model-datatable").DataTable();
            initDatatableEvent('#model-datatable', modelSelectedRows);
        });
    </script>
@endpush

@push('css')
    @include('layouts.datatables_css')
@endpush

<div class="card" style="overflow-y: auto;">
    <div class="card-body">
        {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-hover dataTable', 'id' => 'model-datatable']) !!}
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        var modelSelectedRows = [];

        const fnRowCallBack = ( ele, data, rowIndex ) => {
            let row = $(ele);
            if ( $.inArray(data.id, modelSelectedRows) !== -1 ) {
                if (!row.hasClass('selected_row')) row.addClass('selected_row');
            } else {
                if (row.hasClass('selected_row')) row.removeClass('selected_row');
            }
        };

        $(document).ready(function() {
            const table = $('#model-datatable').DataTable();

            $('table.table tbody').on( 'click', 'tr', function (evt) {
                if ($(evt.target).closest('button').hasClass('datatable-action')) return;

                let id = table.row(this).data().id;
                let index = $.inArray(id, modelSelectedRows);
                $(this).toggleClass('selected_row');
                if ($(this).hasClass('selected_row')) {
                    if ( index === -1 ) modelSelectedRows.push( id );
                } else {
                    if ( index !== -1 ) modelSelectedRows.splice(index, 1);
                }
            } );
        });
    </script>
    @include('layouts.datatables_js')
    @include('vl-admin-tool::models.toolbar_js')
    {!! $dataTable->scripts() !!}
@endpush

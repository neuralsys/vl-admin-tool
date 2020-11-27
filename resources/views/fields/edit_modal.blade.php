<div class="modal fade" id="field-edit-modal">
    <form id="field-edit-form" method="POST" data-template-action="{{route('fields.update', '%s')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('vl-admin-tool-lang::crud.add_new') @lang('vl-admin-tool-lang::models/field.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        @include('vl-admin-tool::fields.fields')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </form>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            fieldEditForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(fieldEditForm, {
                    table: fieldTable,
                    modal: fieldEditModal
                })
            });
        });
    </script>
@endpush

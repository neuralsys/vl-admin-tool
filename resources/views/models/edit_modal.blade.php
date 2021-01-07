<div class="modal fade" id="model-edit-modal">
    <form id="model-edit-form" method="POST" data-template-action="{{route('models.update', '%s')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/model.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        @include('vl-admin-tool::models.fields')
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
        var modelEditModal = $('#model-edit-modal');
        var modelEditForm = $('#model-edit-modal #model-edit-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            modelEditForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(modelEditForm, {
                    table: modelTable,
                    modal: modelEditModal
                })
            });
        });
    </script>
@endpush

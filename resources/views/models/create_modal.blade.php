<div class="modal fade" id="model-create-modal">
    <form id="model-create-form" method="POST" action="{{route('models.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/model.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
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
        var modelCreateModal = $('#model-create-modal');
        var modelCreateForm = $('#model-create-modal #model-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            modelCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(modelCreateForm, {
                    table: modelTable,
                    modal: modelCreateModal
                })
            });
        });
    </script>
@endpush

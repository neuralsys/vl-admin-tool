<div class="modal fade" id="translation-edit-modal">
    <form id="translation-edit-form" method="POST" data-template-action="{{route('translations.update', '%s')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/translation.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        @include('vl-admin-tool::translations.fields')
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
        var translationEditModal = $('#translation-edit-modal');
        var translationEditForm = $('#translation-edit-modal #translation-edit-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            translationEditForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(translationEditForm, {
                    table: translationTable,
                    modal: translationEditModal
                })
            });
        });
    </script>
@endpush

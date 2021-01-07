<div class="modal fade" id="translation-create-modal">
    <form id="translation-create-form" method="POST" action="{{route('translations.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/translation.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('translations.fields')
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
        var translationCreateModal = $('#translation-create-modal');
        var translationCreateForm = $('#translation-create-modal #translation-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            translationCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(translationCreateForm, {
                    table: translationTable,
                    modal: translationCreateModal
                })
            });
        });
    </script>
@endpush

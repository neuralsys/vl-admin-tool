<div class="modal fade" id="translationFile-create-modal">
    <form id="translationFile-create-form" method="POST" action="{{route('translationFiles.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/translationFile.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('translationFiles.fields')
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
        var translationFileCreateModal = $('#translationFile-create-modal');
        var translationFileCreateForm = $('#translationFile-create-modal #translationFile-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            translationFileCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(translationFileCreateForm, {
                    table: translationFileTable,
                    modal: translationFileCreateModal
                })
            });
        });
    </script>
@endpush

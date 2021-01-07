<div class="modal fade" id="lang-create-modal">
    <form id="lang-create-form" method="POST" action="{{route('langs.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/lang.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('langs.fields')
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
        var langCreateModal = $('#lang-create-modal');
        var langCreateForm = $('#lang-create-modal #lang-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            langCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(langCreateForm, {
                    table: langTable,
                    modal: langCreateModal
                })
            });
        });
    </script>
@endpush

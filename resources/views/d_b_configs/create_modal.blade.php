<div class="modal fade" id="dBConfig-create-modal">
    <form id="dBConfig-create-form" method="POST" action="{{route('dBConfigs.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/dBConfig.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('vl-admin-tool::dBConfigs.fields')
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
        var dBConfigCreateModal = $('#dBConfig-create-modal');
        var dBConfigCreateForm = $('#dBConfig-create-modal #dBConfig-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            dBConfigCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(dBConfigCreateForm, {
                    table: dBConfigTable,
                    modal: dBConfigCreateModal
                })
            });
        });
    </script>
@endpush

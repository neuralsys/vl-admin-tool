<div class="modal fade" id="cRUDConfig-create-modal">
    <form id="cRUDConfig-create-form" method="POST" action="{{route('cRUDConfigs.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/cRUDConfig.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('vl-admin-tool::c_r_u_d_configs.fields')
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
        var cRUDConfigCreateModal = $('#cRUDConfig-create-modal');
        var cRUDConfigCreateForm = $('#cRUDConfig-create-modal #cRUDConfig-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            cRUDConfigCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(cRUDConfigCreateForm, {
                    table: cRUDConfigTable,
                    modal: cRUDConfigCreateModal
                })
            });
        });
    </script>
@endpush

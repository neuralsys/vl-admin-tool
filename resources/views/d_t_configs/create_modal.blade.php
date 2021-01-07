<div class="modal fade" id="dTConfig-create-modal">
    <form id="dTConfig-create-form" method="POST" action="{{route('dTConfigs.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/dTConfig.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('vl-admin-tool::dTConfigs.fields')
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
        var dTConfigCreateModal = $('#dTConfig-create-modal');
        var dTConfigCreateForm = $('#dTConfig-create-modal #dTConfig-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            dTConfigCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(dTConfigCreateForm, {
                    table: dTConfigTable,
                    modal: dTConfigCreateModal
                })
            });
        });
    </script>
@endpush

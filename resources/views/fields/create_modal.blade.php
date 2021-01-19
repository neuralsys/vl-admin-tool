<div class="modal fade" id="field-create-modal">
    <form id="field-create-form" method="POST" action="{{route('fields.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/field.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h1 class="float-left">
                        Basic
                    </h1>
                    <div class="clearfix"></div>
                    <div class="row">
                        @include('vl-admin-tool::fields.fields')
                    </div>

                    <h1 class="float-left">
                        DB Config
                    </h1>
                    <div class="clearfix"></div>
                    <div class="row">
                        @include('vl-admin-tool::d_b_configs.fields')
                    </div>

                    <h1 class="float-left">
                        DT Config
                    </h1>
                    <div class="clearfix"></div>
                    <div class="row">
                        @include('vl-admin-tool::d_t_configs.fields')
                    </div>

                    <h1 class="float-left">
                        CRUD Config
                    </h1>
                    <div class="clearfix"></div>
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
        var fieldCreateModal = $('#field-create-modal');
        var fieldCreateForm = $('#field-create-modal #field-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            fieldCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(fieldCreateForm, {
                    table: fieldTable,
                    modal: fieldCreateModal
                })
            });
        });
    </script>
@endpush

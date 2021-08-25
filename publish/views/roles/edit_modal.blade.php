<div class="modal fade" id="role-edit-modal">
    <form id="role-edit-form" method="POST" data-template-action="{{route('roles.update', '%s')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.edit') @lang('models/role.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        @include('roles.fields')
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
        var roleEditModal = $('#role-edit-modal');
        var roleEditForm = $('#role-edit-modal #role-edit-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            roleEditForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(roleEditForm, {
                    table: roleTable,
                    modal: roleEditModal
                })
            });
        });
    </script>
@endpush

<div class="modal fade" id="rolePermission-create-modal">
    <form id="rolePermission-create-form" method="POST" action="{{route('rolePermissions.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/rolePermission.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @include('role_permissions.fields')
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
        var rolePermissionCreateModal = $('#rolePermission-create-modal');
        var rolePermissionCreateForm = $('#rolePermission-create-modal #rolePermission-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            rolePermissionCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(rolePermissionCreateForm, {
                    table: rolePermissionTable,
                    modal: rolePermissionCreateModal,
                    defaultValues: {
                        "permission_id": [null]
                    }
                })
            });
        });
    </script>
@endpush

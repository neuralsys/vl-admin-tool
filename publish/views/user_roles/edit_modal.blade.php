<div class="modal fade" id="userRole-edit-modal">
    <form id="userRole-edit-form" method="POST" data-template-action="{{route('userRoles.update', '%s')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.edit') @lang('models/userRole.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        @include('user_roles.fields')
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
        var userRoleEditModal = $('#userRole-edit-modal');
        var userRoleEditForm = $('#userRole-edit-modal #userRole-edit-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            userRoleEditForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(userRoleEditForm, {
                    table: userRoleTable,
                    modal: userRoleEditModal
                })
            });
        });
    </script>
@endpush

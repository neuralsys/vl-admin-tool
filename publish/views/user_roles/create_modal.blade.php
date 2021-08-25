<div class="modal fade" id="userRole-create-modal">
    <form id="userRole-create-form" method="POST" action="{{route('userRoles.store')}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('crud.add_new') @lang('models/userRole.singular')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
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
        var userRoleCreateModal = $('#userRole-create-modal');
        var userRoleCreateForm = $('#userRole-create-modal #userRole-create-form');
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            userRoleCreateForm.on('submit', (evt) => {
                evt.preventDefault();
                sendFormAjax(userRoleCreateForm, {
                    table: userRoleTable,
                    modal: userRoleCreateModal
                })
            });
        });
    </script>
@endpush

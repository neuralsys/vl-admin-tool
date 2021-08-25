@extends('layouts.app')

@push('css')
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="/vendor/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
@endpush

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-4">
                <h1>
                    @lang('models/rolePermission.plural')
                </h1>
            </div>
            <div class="col-8">
                <h1 class="float-right">
                    <button type="button" class="btn btn-block btn-primary float-right btnAddNewRolePermission"
                            style="margin-top: -10px;margin-bottom: 5px"><i class="fas fa-plus"></i> @lang('crud.add_new')</button>
                </h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('role_permissions.table_with_crud_modals')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap4 Duallistbox -->
    <script src="/vendor/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $('.duallistbox').bootstrapDualListbox({
                "moveOnSelect": false,
                "selectorMinimalHeight": 320,
            });

            $('.btnAddNewRolePermission').on('click', (evt) => {
                let data = rolePermissionTable.rows().data();
                let selectedPermissions = [];
                $.each( data, function( key, value ) {
                    selectedPermissions.push(value.permission_id);
                });
                $('#permission_id').val(selectedPermissions).change();
                $('#permission_id').bootstrapDualListbox("refresh", true);
                rolePermissionCreateModal.modal('show');
            });
        });
    </script>
@endpush

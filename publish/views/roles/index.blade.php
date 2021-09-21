@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-4">
                <h1>
                    @lang('models/role.plural')
                </h1>
            </div>
            <div class="col-8">
                <h1 class="float-right">
                    <button type="button" class="btn btn-block btn-primary float-right btnAddNewRole"
                            style="margin-top: -10px;margin-bottom: 5px"><i class="fas fa-plus"></i> @lang('crud.add_new')</button>
                </h1>

                <h1 class="float-right" style="padding: 0 5px">
                    <button type="button" class="btn btn-block btn-primary float-right btnSyncPermission"
                            style="margin-top: -10px;margin-bottom: 5px"><i class="fas fa-sync"></i> @lang('crud.sync_permission')</button>
                </h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('roles.table_with_crud_modals')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnAddNewRole').on('click', (evt) => {
                resetForm(roleCreateForm);
                roleCreateModal.modal('show');
            });
            $('.btnSyncPermission').on('click', (evt) => {
                sendAjax('{{route('permissions.syncPermission')}}', {}, 'post', {
                    table: roleTable
                })
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-4">
                <h1>
                    @lang('vl-admin-tool-lang::models/model.plural')
                </h1>
            </div>
            <div class="col-8">
                <h1 class="float-right">
                    <button type="button" class="btn btn-block btn-primary float-right btnAddNewModel"
                            style="margin-top: -10px;margin-bottom: 5px"><i class="fas fa-plus"></i> @lang('vl-admin-tool-lang::crud.add_new')</button>
                </h1>

                <h1 class="float-right" style="padding: 0 5px">
                    <button type="button" class="btn btn-block btn-primary float-right btnSyncDB"
                            style="margin-top: -10px;margin-bottom: 5px"><i class="fas fa-sync"></i> @lang('vl-admin-tool-lang::crud.sync_db')</button>
                </h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('vl-admin-tool::models.table_with_crud_modals')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnAddNewModel').on('click', (evt) => {
                resetForm(modelCreateForm);
                modelCreateModal.modal('show');
            });

            $('.btnSyncDB').on('click', (evt) => {
               sendAjax('{{route('models.syncDB')}}', {}, 'post', {
                   table: modelTable
               })
            });
        });
    </script>
@endpush

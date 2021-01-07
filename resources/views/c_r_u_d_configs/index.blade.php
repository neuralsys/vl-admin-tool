@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('vl-admin-tool-lang::models/cRUDConfig.plural')
        </h1>
        <h1 class="float-right">
            <button type="button" class="btn btn-block btn-primary float-right btnAddNewCRUDConfig"
                    style="margin-top: -10px;margin-bottom: 5px">@lang('crud.add_new')</button>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('vl-admin-tool::c_r_u_d_configs.table_with_crud_modals')
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnAddNewCRUDConfig').on('click', (evt) => {
                resetForm(cRUDConfigCreateForm);
                cRUDConfigCreateModal.modal('show');
            });
        });
    </script>
@endpush

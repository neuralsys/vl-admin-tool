@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('vl-admin-tool-lang::models/dBConfig.plural')
        </h1>
        <h1 class="float-right">
            <button type="button" class="btn btn-block btn-primary float-right btnAddNewDBConfig"
                    style="margin-top: -10px;margin-bottom: 5px">@lang('crud.add_new')</button>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('vl-admin-tool::d_b_configs.table_with_crud_modals')
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('.btnAddNewDBConfig').on('click', (evt) => {
                resetForm(dBConfigCreateForm);
                dBConfigCreateModal.modal('show');
            });
        });
    </script>
@endpush

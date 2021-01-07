@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('$NS_LOCALE_PREFIX$models/dBConfig.plural')
        </h1>
        <h1 class="float-right">
            <button type="button" class="btn btn-block btn-primary float-right btnAddNewDBConfig"
                    style="margin-top: -10px;margin-bottom: 5px">@lang('crud.add_new')</button>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('$NS_VIEW_PREFIX$d_b_configs.table_with_crud_modals')
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnAddNewDBConfig').on('click', (evt) => {
                resetForm(dBConfigCreateForm);
                dBConfigCreateModal.modal('show');
            });
        });
    </script>
@endpush

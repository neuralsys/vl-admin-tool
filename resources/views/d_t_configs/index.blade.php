@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('models/dTConfigs.plural')
        </h1>
        <h1 class="float-right">
            <button type="button" class="btn btn-block btn-primary float-right btnAddNewDTConfig"
                    style="margin-top: -10px;margin-bottom: 5px">@lang('crud.add_new')</button>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('d_t_configs.table_with_crud_modals')
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnAddNewDTConfig').on('click', (evt) => {
                resetForm(dTConfigCreateForm);
                dTConfigCreateModal.modal('show');
            });
        });
    </script>
@endpush

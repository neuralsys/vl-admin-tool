@extends('layouts.app')

@push('scripts')

@endpush

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('vl-admin-tool-lang::models/model.plural')
        </h1>
        <h1 class="float-right">
            <button type="button" class="btn btn-block btn-primary float-right btnAddNewModel"
                    style="margin-top: -10px;margin-bottom: 5px">@lang('vl-admin-tool-lang::crud.add_new')</button>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('vl-admin-tool::models.table_with_crud_modals')
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnAddNewModel').on('click', (evt) => {
                resetForm(modelCreateForm);
                modelCreateModal.modal('show');
            });
        });
    </script>
@endpush

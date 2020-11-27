@extends('layouts.app')

@push('scripts')

@endpush

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('vl-admin-tool-lang::models/field.plural')
        </h1>
        <h1 class="float-right">
            <button type="button" class="btn btn-block btn-primary float-right btnAddNewModel"
                    style="margin-top: -10px;margin-bottom: 5px">@lang('vl-admin-tool-lang::crud.add_new')</button>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <div class="clearfix"></div>
        @include('vl-admin-tool::fields.table')
    </div>

    @include('vl-admin-tool::fields.create_modal')
    @include('vl-admin-tool::fields.edit_modal')
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnAddNewModel').on('click', (evt) => {
                resetForm(fieldCreateForm);
                fieldCreateModal.modal('show');
            });
        });
    </script>
@endpush

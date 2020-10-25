@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('vl-admin-tool-lang::models/model.plural')
        </h1>
        <h1 class="float-right">
            <button type="button" class="btn btn-block btn-primary float-right btnAddNew"
                    style="margin-top: -10px;margin-bottom: 5px">@lang('vl-admin-tool-lang::crud.add_new')</button>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <div class="clearfix"></div>
        @include('vl-admin-tool::models.table')
    </div>

    @include('vl-admin-tool::models.create_modal')
@endsection

@push('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('.btnAddNew').on('click', (evt) => {
                $('#model-create-modal').modal('show');
            });
        });
    </script>
@endpush

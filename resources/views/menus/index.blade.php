@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('vl-admin-tool-lang::models/menu.plural')
        </h1>
        <h1 class="float-right">
            <button type="button" class="btn btn-block btn-primary float-right btnAddNewMenu"
                    style="margin-top: -10px;margin-bottom: 5px">@lang('crud.add_new')</button>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('vl-admin-tool::menus.table_with_crud_modals')
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('.btnAddNewMenu').on('click', (evt) => {
                resetForm(menuCreateForm);
                menuCreateModal.modal('show');
            });
        });

    </script>
@endpush

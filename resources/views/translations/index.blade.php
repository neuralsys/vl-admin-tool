@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="float-left">
            @lang('models/translations.plural')
        </h1>
        <h1 class="float-right">
           <a class="btn btn-primary float-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('translations.create') }}">@lang('crud.add_new')</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('translations.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection


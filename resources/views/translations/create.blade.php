@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('models/translations.singular')
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'translations.store']) !!}

                        @include('translations.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

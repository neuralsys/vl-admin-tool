@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('models/models.singular')
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'models.store']) !!}

                        @include('models.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

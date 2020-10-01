@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('vl-admin-tool-lang::models/model.singular')
        </h1>
    </section>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'models.store']) !!}

                        @include('vl-admin-tool::models.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

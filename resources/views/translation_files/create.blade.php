@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('models/translationFiles.singular')
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'translationFiles.store']) !!}

                        @include('translation_files.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

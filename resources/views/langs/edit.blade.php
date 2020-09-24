@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('models/langs.singular')
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($lang, ['route' => ['langs.update', $lang->id], 'method' => 'patch']) !!}

                        @include('langs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

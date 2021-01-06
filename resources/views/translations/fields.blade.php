<!-- File Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/translations.fields.file_id').':') !!}
    {!! Form::number('file_id', null, ['class' => 'form-control', 'data-column' => 'file_id']) !!}
</div>


<!-- Lang Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/translations.fields.lang_id').':') !!}
    {!! Form::number('lang_id', null, ['class' => 'form-control', 'data-column' => 'lang_id']) !!}
</div>


<!-- Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/translations.fields.key').':') !!}
    {!! Form::text('key', null, ['class' => 'form-control', 'data-column' => 'key']) !!}
</div>


<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/translations.fields.value').':') !!}
    {!! Form::text('value', null, ['class' => 'form-control', 'data-column' => 'value']) !!}
</div>


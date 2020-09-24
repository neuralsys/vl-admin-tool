<!-- File Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('file_id', __('models/translations.fields.file_id').':') !!}
    {!! Form::number('file_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Lang Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('lang_id', __('models/translations.fields.lang_id').':') !!}
    {!! Form::number('lang_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label('key', __('models/translations.fields.key').':') !!}
    {!! Form::text('key', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', __('models/translations.fields.value').':') !!}
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('translations.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
</div>

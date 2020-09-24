<!-- File Id Field -->
<div class="form-group">
    {!! Form::label('file_id', __('models/translations.fields.file_id').':') !!}
    <p>{{ $translation->file_id }}</p>
</div>

<!-- Lang Id Field -->
<div class="form-group">
    {!! Form::label('lang_id', __('models/translations.fields.lang_id').':') !!}
    <p>{{ $translation->lang_id }}</p>
</div>

<!-- Key Field -->
<div class="form-group">
    {!! Form::label('key', __('models/translations.fields.key').':') !!}
    <p>{{ $translation->key }}</p>
</div>

<!-- Value Field -->
<div class="form-group">
    {!! Form::label('value', __('models/translations.fields.value').':') !!}
    <p>{{ $translation->value }}</p>
</div>


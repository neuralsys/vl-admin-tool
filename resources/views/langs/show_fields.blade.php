<!-- Language Field -->
<div class="form-group">
    {!! Form::label('language', __('models/langs.fields.language').':') !!}
    <p>{{ $lang->language }}</p>
</div>

<!-- Locale Field -->
<div class="form-group">
    {!! Form::label('locale', __('models/langs.fields.locale').':') !!}
    <p>{{ $lang->locale }}</p>
</div>


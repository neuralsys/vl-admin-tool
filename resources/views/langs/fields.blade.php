<!-- Language Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/langs.fields.language').':') !!}
    {!! Form::text('language', null, ['class' => 'form-control', 'data-column' => 'language']) !!}
</div>


<!-- Locale Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/langs.fields.locale').':') !!}
    {!! Form::text('locale', null, ['class' => 'form-control', 'data-column' => 'locale']) !!}
</div>


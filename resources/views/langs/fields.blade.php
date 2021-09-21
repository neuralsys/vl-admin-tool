<!-- Language Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/lang.fields.language').':') !!}
    {!! Form::text('language', null, ['class' => 'form-control', 'data-column' => 'language']) !!}
</div>


<!-- Locale Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/lang.fields.locale').':') !!}
    {!! Form::text('locale', null, ['class' => 'form-control', 'data-column' => 'locale']) !!}
</div>


<!-- Model Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/field.fields.model_id').':') !!}
    {!! Form::number('model_id', null, ['class' => 'form-control', 'data-column' => 'model_id']) !!}
</div>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/field.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'data-column' => 'name']) !!}
</div>


<!-- Html Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/field.fields.html_type').':') !!}
    {!! Form::text('html_type', null, ['class' => 'form-control', 'data-column' => 'html_type']) !!}
</div>


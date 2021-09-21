<!-- Model Id Field -->
<div class="form-group col-sm-6" style="display:none;">
    {!! Form::label(null, __('vl-admin-tool-lang::models/field.fields.model_id').':') !!}
    {!! Form::number('model_id', $model_id, ['class' => 'form-control ignore-reset', 'data-column' => 'model_id']) !!}
</div>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/field.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'data-column' => 'name']) !!}
</div>


<!-- Html Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/field.fields.html_type').':') !!}
    {!! Form::select('html_type', $fieldTypes, null, ['placeholder' => 'Choose HTML Type', 'class' => 'form-control select2', 'data-column' => 'html_type', 'style' => "width: 100%"]) !!}
</div>


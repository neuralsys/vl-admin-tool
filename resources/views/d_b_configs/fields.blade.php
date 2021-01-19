<!-- Field Id Field -->
<div class="form-group col-sm-6" style="display: none">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dBConfig.fields.field_id').':') !!}
    {!! Form::number('field_id', null, ['class' => 'form-control', 'data-column' => 'db_config.field_id']) !!}
</div>


<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dBConfig.fields.type').':') !!}
    {!! Form::select('type', $dbTypes, null, ['class' => 'form-control select2', 'data-column' => 'db_config.type']) !!}
</div>


<!-- Length Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dBConfig.fields.length').':') !!}
    {!! Form::number('length', null, ['class' => 'form-control', 'data-column' => 'db_config.length']) !!}
</div>


<!-- Nullable Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dBConfig.fields.nullable').':') !!}
    {!! Form::number('nullable', null, ['class' => 'form-control', 'data-column' => 'db_config.nullable']) !!}
</div>


<!-- Unique Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dBConfig.fields.unique').':') !!}
    {!! Form::number('unique', null, ['class' => 'form-control', 'data-column' => 'db_config.unique']) !!}
</div>


<!-- Default Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dBConfig.fields.default').':') !!}
    {!! Form::text('default', null, ['class' => 'form-control', 'data-column' => 'db_config.default']) !!}
</div>


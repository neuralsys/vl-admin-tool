<!-- Field Id Field -->
<div class="form-group col-sm-6" style="display: none">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dBConfig.fields.field_id').':') !!}
    {!! Form::number('field_id', $field_id, ['class' => 'form-control ignore-reset', 'data-column' => 'field_id']) !!}
</div>


<!-- Creatable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('creatable', 0) !!}
        {!! Form::checkbox('creatable', '1', null, ['data-column' => 'creatable']) !!} {{__('vl-admin-tool-lang::models/cRUDConfig.fields.creatable')}}
    </label>
</div>


<!-- Editable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('editable', 0) !!}
        {!! Form::checkbox('editable', '1', null, ['data-column' => 'editable']) !!} {{__('vl-admin-tool-lang::models/cRUDConfig.fields.editable')}}
    </label>
</div>


<!-- Rules Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/cRUDConfig.fields.rules').':') !!}
    {!! Form::text('rules', null, ['class' => 'form-control', 'data-column' => 'rules']) !!}
</div>


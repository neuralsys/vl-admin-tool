<!-- Field Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/cRUDConfigs.fields.field_id').':') !!}
    {!! Form::number('field_id', null, ['class' => 'form-control', 'data-column' => 'field_id']) !!}
</div>


<!-- Creatable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('creatable', 0) !!}
        {!! Form::checkbox('creatable', '1', null, ['data-column' => 'creatable']) !!} {{__('models/cRUDConfigs.fields.creatable')}}
    </label>
</div>


<!-- Editable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('editable', 0) !!}
        {!! Form::checkbox('editable', '1', null, ['data-column' => 'editable']) !!} {{__('models/cRUDConfigs.fields.editable')}}
    </label>
</div>


<!-- Rules Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/cRUDConfigs.fields.rules').':') !!}
    {!! Form::text('rules', null, ['class' => 'form-control', 'data-column' => 'rules']) !!}
</div>


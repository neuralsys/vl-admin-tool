<!-- Field Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/dBConfigs.fields.field_id').':') !!}
    {!! Form::number('field_id', null, ['class' => 'form-control', 'data-column' => 'field_id']) !!}
</div>


<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/dBConfigs.fields.type').':') !!}
    {!! Form::text('type', null, ['class' => 'form-control', 'data-column' => 'type']) !!}
</div>


<!-- Length Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/dBConfigs.fields.length').':') !!}
    {!! Form::number('length', null, ['class' => 'form-control', 'data-column' => 'length']) !!}
</div>


<!-- Nullable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('nullable', 0) !!}
        {!! Form::checkbox('nullable', '1', null, ['data-column' => 'nullable']) !!} {{__('models/dBConfigs.fields.nullable')}}
    </label>
</div>


<!-- Unique Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('unique', 0) !!}
        {!! Form::checkbox('unique', '1', null, ['data-column' => 'unique']) !!} {{__('models/dBConfigs.fields.unique')}}
    </label>
</div>


<!-- Default Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/dBConfigs.fields.default').':') !!}
    {!! Form::text('default', null, ['class' => 'form-control', 'data-column' => 'default']) !!}
</div>


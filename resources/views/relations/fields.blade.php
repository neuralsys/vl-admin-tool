<!-- Second Field Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/relations.fields.second_field_id').':') !!}
    {!! Form::number('second_field_id', null, ['class' => 'form-control', 'data-column' => 'second_field_id']) !!}
</div>


<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/relations.fields.type').':') !!}
    {!! Form::text('type', null, ['class' => 'form-control', 'data-column' => 'type']) !!}
</div>


<!-- Table Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/relations.fields.table_name').':') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control', 'data-column' => 'table_name']) !!}
</div>


<!-- Fk 1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/relations.fields.fk_1').':') !!}
    {!! Form::text('fk_1', null, ['class' => 'form-control', 'data-column' => 'fk_1']) !!}
</div>


<!-- Fk 2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/relations.fields.fk_2').':') !!}
    {!! Form::text('fk_2', null, ['class' => 'form-control', 'data-column' => 'fk_2']) !!}
</div>


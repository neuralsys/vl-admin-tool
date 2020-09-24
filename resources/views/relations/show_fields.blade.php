<!-- Type Field -->
<div class="form-group">
    {!! Form::label('type', __('models/relations.fields.type').':') !!}
    <p>{{ $relation->type }}</p>
</div>

<!-- First Models Id Field -->
<div class="form-group">
    {!! Form::label('first_model_id', __('models/relations.fields.first_model_id').':') !!}
    <p>{{ $relation->first_model_id }}</p>
</div>

<!-- First Foreign Key Field -->
<div class="form-group">
    {!! Form::label('first_foreign_key', __('models/relations.fields.first_foreign_key').':') !!}
    <p>{{ $relation->first_foreign_key }}</p>
</div>

<!-- Second Models Id Field -->
<div class="form-group">
    {!! Form::label('second_model_id', __('models/relations.fields.second_model_id').':') !!}
    <p>{{ $relation->second_model_id }}</p>
</div>

<!-- Second Foreign Key Field -->
<div class="form-group">
    {!! Form::label('second_foreign_key', __('models/relations.fields.second_foreign_key').':') !!}
    <p>{{ $relation->second_foreign_key }}</p>
</div>

<!-- Table Name Field -->
<div class="form-group">
    {!! Form::label('table_name', __('models/relations.fields.table_name').':') !!}
    <p>{{ $relation->table_name }}</p>
</div>

<!-- First Key Field -->
<div class="form-group">
    {!! Form::label('first_key', __('models/relations.fields.first_key').':') !!}
    <p>{{ $relation->first_key }}</p>
</div>

<!-- Second Key Field -->
<div class="form-group">
    {!! Form::label('second_key', __('models/relations.fields.second_key').':') !!}
    <p>{{ $relation->second_key }}</p>
</div>


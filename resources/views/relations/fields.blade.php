<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', __('models/relations.fields.type').':') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div>

<!-- First Models Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_model_id', __('models/relations.fields.first_model_id').':') !!}
    {!! Form::number('first_model_id', null, ['class' => 'form-control']) !!}
</div>

<!-- First Foreign Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_foreign_key', __('models/relations.fields.first_foreign_key').':') !!}
    {!! Form::text('first_foreign_key', null, ['class' => 'form-control']) !!}
</div>

<!-- Second Models Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('second_model_id', __('models/relations.fields.second_model_id').':') !!}
    {!! Form::number('second_model_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Second Foreign Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label('second_foreign_key', __('models/relations.fields.second_foreign_key').':') !!}
    {!! Form::text('second_foreign_key', null, ['class' => 'form-control']) !!}
</div>

<!-- Table Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('table_name', __('models/relations.fields.table_name').':') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control']) !!}
</div>

<!-- First Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_key', __('models/relations.fields.first_key').':') !!}
    {!! Form::text('first_key', null, ['class' => 'form-control']) !!}
</div>

<!-- Second Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label('second_key', __('models/relations.fields.second_key').':') !!}
    {!! Form::text('second_key', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('relations.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
</div>

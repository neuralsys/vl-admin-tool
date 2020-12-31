<!-- Model Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model_id', __('models/fields.fields.model_id').':') !!}
    {!! Form::number('model_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/fields.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Db Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('db_type', __('models/fields.fields.db_type').':') !!}
    {!! Form::text('db_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Html Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('html_type', __('models/fields.fields.html_type').':') !!}
    {!! Form::text('html_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Primary Field -->
<div class="form-group col-sm-6">
    {!! Form::label('primary', __('models/fields.fields.primary').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('primary', 0) !!}
        {!! Form::checkbox('primary', '1', null) !!} 1
    </label>
</div>

<!-- Unique Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unique', __('models/fields.fields.unique').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('unique', 0) !!}
        {!! Form::checkbox('unique', '1', null) !!} 1
    </label>
</div>

<!-- Auto Increment Field -->
<div class="form-group col-sm-6">
    {!! Form::label('auto_increment', __('models/fields.fields.auto_increment').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('auto_increment', 0) !!}
        {!! Form::checkbox('auto_increment', '1', null) !!} 1
    </label>
</div>

<!-- Nullable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nullable', __('models/fields.fields.nullable').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('nullable', 0) !!}
        {!! Form::checkbox('nullable', '1', null) !!} 1
    </label>
</div>

<!-- Creatable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('creatable', __('models/fields.fields.creatable').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('creatable', 0) !!}
        {!! Form::checkbox('creatable', '1', null) !!} 1
    </label>
</div>

<!-- Editable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('editable', __('models/fields.fields.editable').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('editable', 0) !!}
        {!! Form::checkbox('editable', '1', null) !!} 1
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('fields.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
</div>

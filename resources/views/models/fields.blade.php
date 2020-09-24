<!-- Class Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('class_name', __('models/models.fields.class_name').':') !!}
    {!! Form::text('class_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Table Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('table_name', __('models/models.fields.table_name').':') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('models/models.fields.description').':') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Timestamps Field -->
<div class="form-group col-sm-6">
    {!! Form::label('timestamps', __('models/models.fields.timestamps').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('timestamps', 0) !!}
        {!! Form::checkbox('timestamps', '1', null) !!} 1
    </label>
</div>

<!-- Soft Delete Field -->
<div class="form-group col-sm-6">
    {!! Form::label('soft_delete', __('models/models.fields.soft_delete').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('soft_delete', 0) !!}
        {!! Form::checkbox('soft_delete', '1', null) !!} 1
    </label>
</div>

<!-- Test Field -->
<div class="form-group col-sm-6">
    {!! Form::label('test', __('models/models.fields.test').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('test', 0) !!}
        {!! Form::checkbox('test', '1', null) !!} 1
    </label>
</div>

<!-- Swagger Field -->
<div class="form-group col-sm-6">
    {!! Form::label('swagger', __('models/models.fields.swagger').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('swagger', 0) !!}
        {!! Form::checkbox('swagger', '1', null) !!} 1
    </label>
</div>

<!-- Datatables Field -->
<div class="form-group col-sm-6">
    {!! Form::label('datatables', __('models/models.fields.datatables').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('datatables', 0) !!}
        {!! Form::checkbox('datatables', '1', null) !!} 1
    </label>
</div>

<!-- Paginate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('paginate', __('models/models.fields.paginate').':') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('paginate', 0) !!}
        {!! Form::checkbox('paginate', '1', null) !!} 1
    </label>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('models.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
</div>

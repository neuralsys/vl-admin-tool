<!-- Project Id Field -->
<div class="form-group">
    {!! Form::label('project_id', __('models/models.fields.project_id').':') !!}
    <p>{{ $model->project_id }}</p>
</div>

<!-- Class Name Field -->
<div class="form-group">
    {!! Form::label('class_name', __('models/models.fields.class_name').':') !!}
    <p>{{ $model->class_name }}</p>
</div>

<!-- Table Name Field -->
<div class="form-group">
    {!! Form::label('table_name', __('models/models.fields.table_name').':') !!}
    <p>{{ $model->table_name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', __('models/models.fields.description').':') !!}
    <p>{{ $model->description }}</p>
</div>

<!-- Timestamps Field -->
<div class="form-group">
    {!! Form::label('timestamps', __('models/models.fields.timestamps').':') !!}
    <p>{{ $model->timestamps }}</p>
</div>

<!-- Soft Delete Field -->
<div class="form-group">
    {!! Form::label('soft_delete', __('models/models.fields.soft_delete').':') !!}
    <p>{{ $model->soft_delete }}</p>
</div>

<!-- Test Field -->
<div class="form-group">
    {!! Form::label('test', __('models/models.fields.test').':') !!}
    <p>{{ $model->test }}</p>
</div>

<!-- Swagger Field -->
<div class="form-group">
    {!! Form::label('swagger', __('models/models.fields.swagger').':') !!}
    <p>{{ $model->swagger }}</p>
</div>

<!-- Datatables Field -->
<div class="form-group">
    {!! Form::label('datatables', __('models/models.fields.datatables').':') !!}
    <p>{{ $model->datatables }}</p>
</div>

<!-- Paginate Field -->
<div class="form-group">
    {!! Form::label('paginate', __('models/models.fields.paginate').':') !!}
    <p>{{ $model->paginate }}</p>
</div>


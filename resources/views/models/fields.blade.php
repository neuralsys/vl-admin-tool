<!-- Class Name Field -->
<div class="col-sm-6">
    <div class="form-group">
        {!! Form::label('class_name', __('vl-admin-tool-lang::models/model.fields.class_name').':') !!}
        {!! Form::text('class_name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Table Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('table_name', __('vl-admin-tool-lang::models/model.fields.table_name').':') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Singular Field -->
<div class="form-group col-sm-6">
    {!! Form::label('singular', __('vl-admin-tool-lang::models/model.fields.singular').':') !!}
    {!! Form::text('singular', null, ['class' => 'form-control']) !!}
</div>

<!-- Plural Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plurals', __('vl-admin-tool-lang::models/model.fields.plurals').':') !!}
    {!! Form::text('plurals', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('vl-admin-tool-lang::models/model.fields.description').':') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Timestamps Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('timestamps', '1', true, ['id' => 'timestamps']) !!}
    {!! Form::label('timestamps', __('vl-admin-tool-lang::models/model.fields.timestamps')) !!}
</div>

<!-- Soft Delete Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('soft_delete', '1', true, ['id' => 'soft_delete']) !!}
    {!! Form::label('soft_delete', __('vl-admin-tool-lang::models/model.fields.soft_delete')) !!}
</div>

<!-- Test Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('test', '1', true, ['id' => 'test']) !!}
    {!! Form::label('test', __('vl-admin-tool-lang::models/model.fields.test')) !!}
</div>

<!-- Swagger Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('swagger', '1', false, ['id' => 'swagger']) !!}
    {!! Form::label('swagger', __('vl-admin-tool-lang::models/model.fields.swagger')) !!}
</div>

<!-- Datatables Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('datatables', '1', true, ['id' => 'datatables']) !!}
    {!! Form::label('datatables', __('vl-admin-tool-lang::models/model.fields.datatables')) !!}
</div>

<!-- Paginate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('paginate', __('vl-admin-tool-lang::models/model.fields.paginate')) !!}
    {!! Form::number('paginate', 15, ['class' => 'form-control']) !!}
</div>

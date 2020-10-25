@php
    $uuid = rand(1, 10000);
@endphp
<!-- Class Name Field -->
<div class="col-sm-6">
    <div class="form-group">
        {!! Form::label('class_name'.$uuid, __('vl-admin-tool-lang::models/model.fields.class_name').':') !!}
        {!! Form::text('class_name', null, ['class' => 'form-control', "data-column" => "class_name", "id" => 'class_name'.$uuid]) !!}
    </div>
</div>

<!-- Table Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('table_name'.$uuid, __('vl-admin-tool-lang::models/model.fields.table_name').':') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control', "data-column" => "table_name", "id" => 'table_name'.$uuid]) !!}
</div>

<!-- Singular Field -->
<div class="form-group col-sm-6">
    {!! Form::label('singular'.$uuid, __('vl-admin-tool-lang::models/model.fields.singular').':') !!}
    {!! Form::text('singular', null, ['class' => 'form-control', "data-column" => "singular", "id" => 'singular'.$uuid]) !!}
</div>

<!-- Plural Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plurals'.$uuid, __('vl-admin-tool-lang::models/model.fields.plurals').':') !!}
    {!! Form::text('plurals', null, ['class' => 'form-control', "data-column" => "plurals", "id" => 'plurals'.$uuid]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description'.$uuid, __('vl-admin-tool-lang::models/model.fields.description').':') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', "data-column" => "description", "id" => 'description'.$uuid]) !!}
</div>

<!-- Timestamps Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('timestamps', '1', true, ['id' => 'timestamps'.$uuid, "data-column" => "timestamps"]) !!}
    {!! Form::label('timestamps'.$uuid, __('vl-admin-tool-lang::models/model.fields.timestamps')) !!}
</div>

<!-- Soft Delete Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('soft_delete', '1', true, ["data-column" => "soft_delete", "id" => 'soft_delete'.$uuid]) !!}
    {!! Form::label('soft_delete'.$uuid, __('vl-admin-tool-lang::models/model.fields.soft_delete')) !!}
</div>

<!-- Test Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('test', '1', true, ["data-column" => "test", "id" => 'test'.$uuid]) !!}
    {!! Form::label('test'.$uuid, __('vl-admin-tool-lang::models/model.fields.test')) !!}
</div>

<!-- Swagger Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('swagger', '1', false, ["data-column" => "swagger", "id" => 'swagger'.$uuid]) !!}
    {!! Form::label('swagger'.$uuid, __('vl-admin-tool-lang::models/model.fields.swagger')) !!}
</div>

<!-- Datatables Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('datatables', '1', true, ["data-column" => "datatables", "id" => 'datatables'.$uuid]) !!}
    {!! Form::label('datatables'.$uuid, __('vl-admin-tool-lang::models/model.fields.datatables')) !!}
</div>

<!-- Paginate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('paginate'.$uuid, __('vl-admin-tool-lang::models/model.fields.paginate')) !!}
    {!! Form::number('paginate', 15, ['class' => 'form-control', "data-default-value" => 15, "data-column" => "paginate", "id" => 'paginate'.$uuid]) !!}
</div>

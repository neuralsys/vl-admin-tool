<!-- Class Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/model.fields.class_name').':') !!}
    {!! Form::text('class_name', null, ['class' => 'form-control', 'data-column' => 'class_name']) !!}
</div>


<!-- Table Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/model.fields.table_name').':') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control', 'data-column' => 'table_name']) !!}
</div>


<!-- Singular Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/model.fields.singular').':') !!}
    {!! Form::text('singular', null, ['class' => 'form-control', 'data-column' => 'singular']) !!}
</div>


<!-- Plural Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/model.fields.plural').':') !!}
    {!! Form::text('plural', null, ['class' => 'form-control', 'data-column' => 'plural']) !!}
</div>


<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label(null, __('vl-admin-tool-lang::models/model.fields.description').':') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'data-column' => 'description']) !!}
</div>


<!-- Timestamps Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('use_timestamps', 0) !!}
        {!! Form::checkbox('use_timestamps', '1', null, ['data-column' => 'use_timestamps']) !!} {{__('vl-admin-tool-lang::models/model.fields.use_timestamps')}}
    </label>
</div>


<!-- Soft Delete Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('use_soft_delete', 0) !!}
        {!! Form::checkbox('use_soft_delete', '1', null, ['data-column' => 'use_soft_delete']) !!} {{__('vl-admin-tool-lang::models/model.fields.use_soft_delete')}}
    </label>
</div>

<!-- Is Authenticate Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('is_authenticate', 0) !!}
        {!! Form::checkbox('is_authenticate', '1', null, ['data-column' => 'is_authenticate']) !!} {{__('vl-admin-tool-lang::models/model.fields.is_authenticate')}}
    </label>
</div>

<!-- Class Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('class_name', __('vl-admin-tool-lang::models/model.fields.class_name').':') !!}
    {!! Form::text('class_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Table Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('table_name', __('vl-admin-tool-lang::models/model.fields.table_name').':') !!}
    {!! Form::text('table_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('vl-admin-tool-lang::models/model.fields.description').':') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Timestamps Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('timestamps', '1', null) !!} {{__('vl-admin-tool-lang::models/model.fields.timestamps')}}
</div>

<!-- Soft Delete Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('soft_delete', '1', null) !!} {{__('vl-admin-tool-lang::models/model.fields.soft_delete')}}
</div>

<!-- Test Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('test', '1', null) !!} {{__('vl-admin-tool-lang::models/model.fields.test')}}
</div>

<!-- Swagger Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('swagger', '1', null) !!} {{__('vl-admin-tool-lang::models/model.fields.swagger')}}
</div>

<!-- Datatables Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('datatables', '1', null) !!} {{__('vl-admin-tool-lang::models/model.fields.datatables')}}
</div>

<!-- Paginate Field -->
<div class="form-group col-sm-6">
    {!! Form::checkbox('paginate', '1', null) !!} {{__('vl-admin-tool-lang::models/model.fields.paginate')}}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('vl-admin-tool-lang::crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('models.index') }}" class="btn btn-default">@lang('vl-admin-tool-lang::crud.cancel')</a>
</div>

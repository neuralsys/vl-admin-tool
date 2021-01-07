<!-- Field Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dTConfig.fields.field_id').':') !!}
    {!! Form::number('field_id', null, ['class' => 'form-control', 'data-column' => 'field_id']) !!}
</div>


<!-- Showable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('showable', 0) !!}
        {!! Form::checkbox('showable', '1', null, ['data-column' => 'showable']) !!} {{__('vl-admin-tool-lang::models/dTConfig.fields.showable')}}
    </label>
</div>


<!-- Searchable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('searchable', 0) !!}
        {!! Form::checkbox('searchable', '1', null, ['data-column' => 'searchable']) !!} {{__('vl-admin-tool-lang::models/dTConfig.fields.searchable')}}
    </label>
</div>


<!-- Orderable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('orderable', 0) !!}
        {!! Form::checkbox('orderable', '1', null, ['data-column' => 'orderable']) !!} {{__('vl-admin-tool-lang::models/dTConfig.fields.orderable')}}
    </label>
</div>


<!-- Exportable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('exportable', 0) !!}
        {!! Form::checkbox('exportable', '1', null, ['data-column' => 'exportable']) !!} {{__('vl-admin-tool-lang::models/dTConfig.fields.exportable')}}
    </label>
</div>


<!-- Printable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('printable', 0) !!}
        {!! Form::checkbox('printable', '1', null, ['data-column' => 'printable']) !!} {{__('vl-admin-tool-lang::models/dTConfig.fields.printable')}}
    </label>
</div>


<!-- Class Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/dTConfig.fields.class').':') !!}
    {!! Form::text('class', null, ['class' => 'form-control', 'data-column' => 'class']) !!}
</div>


<!-- Has Footer Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('has_footer', 0) !!}
        {!! Form::checkbox('has_footer', '1', null, ['data-column' => 'has_footer']) !!} {{__('vl-admin-tool-lang::models/dTConfig.fields.has_footer')}}
    </label>
</div>


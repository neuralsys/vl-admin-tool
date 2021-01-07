<!-- Field Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/dTConfigs.fields.field_id').':') !!}
    {!! Form::number('field_id', null, ['class' => 'form-control', 'data-column' => 'field_id']) !!}
</div>


<!-- Showable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('showable', 0) !!}
        {!! Form::checkbox('showable', '1', null, ['data-column' => 'showable']) !!} {{__('models/dTConfigs.fields.showable')}}
    </label>
</div>


<!-- Searchable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('searchable', 0) !!}
        {!! Form::checkbox('searchable', '1', null, ['data-column' => 'searchable']) !!} {{__('models/dTConfigs.fields.searchable')}}
    </label>
</div>


<!-- Orderable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('orderable', 0) !!}
        {!! Form::checkbox('orderable', '1', null, ['data-column' => 'orderable']) !!} {{__('models/dTConfigs.fields.orderable')}}
    </label>
</div>


<!-- Exportable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('exportable', 0) !!}
        {!! Form::checkbox('exportable', '1', null, ['data-column' => 'exportable']) !!} {{__('models/dTConfigs.fields.exportable')}}
    </label>
</div>


<!-- Printable Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('printable', 0) !!}
        {!! Form::checkbox('printable', '1', null, ['data-column' => 'printable']) !!} {{__('models/dTConfigs.fields.printable')}}
    </label>
</div>


<!-- Class Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/dTConfigs.fields.class').':') !!}
    {!! Form::text('class', null, ['class' => 'form-control', 'data-column' => 'class']) !!}
</div>


<!-- Has Footer Field -->
<div class="form-group col-sm-6">
    <label class="checkbox-inline">
        {!! Form::hidden('has_footer', 0) !!}
        {!! Form::checkbox('has_footer', '1', null, ['data-column' => 'has_footer']) !!} {{__('models/dTConfigs.fields.has_footer')}}
    </label>
</div>


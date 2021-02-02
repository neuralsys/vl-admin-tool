<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/menu.fields.type').':') !!}
    {!! Form::select('type',$menuTypes, null, ['placeholder' => 'Choose Type', 'class' => 'form-control select2', 'data-column' => 'type', 'style' => "width: 100%"]) !!}
</div>

<!-- Url Pattern Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/menu.fields.url_pattern').':') !!}
    {!! Form::text('url_pattern', null, ['class' => 'form-control', 'data-column' => 'url_pattern']) !!}
</div>


<!-- Index Route Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/menu.fields.index_route_name').':') !!}
    {!! Form::text('index_route_name', null, ['class' => 'form-control', 'data-column' => 'index_route_name']) !!}
</div>


<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/menu.fields.title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'data-column' => 'title']) !!}
</div>


<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/menu.fields.parent_id').':') !!}
    {!! Form::select('parent_id', $parents, 0, ['class' => 'form-control select2', 'data-column' => 'parent_id', 'data-default-value' => '0', 'style' => "width: 100%"]) !!}
</div>


<!-- Pos Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('vl-admin-tool-lang::models/menu.fields.pos').':') !!}
    {!! Form::number('pos', null, ['class' => 'form-control', 'data-column' => 'pos']) !!}
</div>


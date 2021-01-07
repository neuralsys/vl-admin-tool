<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/menus.fields.type').':') !!}
    {!! Form::text('type', null, ['class' => 'form-control', 'data-column' => 'type']) !!}
</div>


<!-- Url Pattern Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/menus.fields.url_pattern').':') !!}
    {!! Form::text('url_pattern', null, ['class' => 'form-control', 'data-column' => 'url_pattern']) !!}
</div>


<!-- Index Route Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/menus.fields.index_route_name').':') !!}
    {!! Form::text('index_route_name', null, ['class' => 'form-control', 'data-column' => 'index_route_name']) !!}
</div>


<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/menus.fields.title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'data-column' => 'title']) !!}
</div>


<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/menus.fields.parent_id').':') !!}
    {!! Form::number('parent_id', null, ['class' => 'form-control', 'data-column' => 'parent_id']) !!}
</div>


<!-- Pos Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/menus.fields.pos').':') !!}
    {!! Form::number('pos', null, ['class' => 'form-control', 'data-column' => 'pos']) !!}
</div>


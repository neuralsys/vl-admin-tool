<!-- Url Pattern Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url_pattern', __('models/menus.fields.url_pattern').':') !!}
    {!! Form::text('url_pattern', null, ['class' => 'form-control']) !!}
</div>

<!-- Index Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('index_url', __('models/menus.fields.index_url').':') !!}
    {!! Form::text('index_url', null, ['class' => 'form-control']) !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', __('models/menus.fields.title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Parent Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parent_id', __('models/menus.fields.parent_id').':') !!}
    {!! Form::number('parent_id', null, ['class' => 'form-control']) !!}
</div>

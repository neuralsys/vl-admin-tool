<!-- Url Pattern Field -->
<div class="form-group">
    {!! Form::label('url_pattern', __('models/menus.fields.url_pattern').':') !!}
    <p>{{ $menu->url_pattern }}</p>
</div>

<!-- Index Url Field -->
<div class="form-group">
    {!! Form::label('index_url', __('models/menus.fields.index_url').':') !!}
    <p>{{ $menu->index_url }}</p>
</div>

<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', __('models/menus.fields.title').':') !!}
    <p>{{ $menu->title }}</p>
</div>

<!-- Parent Id Field -->
<div class="form-group">
    {!! Form::label('parent_id', __('models/menus.fields.parent_id').':') !!}
    <p>{{ $menu->parent_id }}</p>
</div>


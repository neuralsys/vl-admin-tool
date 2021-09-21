<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/role.fields.code').':') !!}
    {!! Form::text(
        'code',
        null,
        [
            'class' => 'form-control',
            'data-column' => 'code',
            'data-default-value' => null
        ]) !!}
</div>


<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/role.fields.title').':') !!}
    {!! Form::text(
        'title',
        null,
        [
            'class' => 'form-control',
            'data-column' => 'title',
            'data-default-value' => null
        ]) !!}
</div>


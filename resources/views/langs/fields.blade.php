<!-- Language Field -->
<div class="form-group col-sm-6">
    {!! Form::label('language', __('models/langs.fields.language').':') !!}
    {!! Form::text('language', null, ['class' => 'form-control']) !!}
</div>

<!-- Locale Field -->
<div class="form-group col-sm-6">
    {!! Form::label('locale', __('models/langs.fields.locale').':') !!}
    {!! Form::text('locale', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('langs.index') }}" class="btn btn-default">@lang('crud.cancel')</a>
</div>

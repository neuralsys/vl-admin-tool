<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/userRole.fields.user_id').':') !!}
    {!! Form::select('user_id', $userIdOptions, null, ['class' => 'form-control select2', 'data-column' => 'user_id']) !!}
</div>


<!-- Role Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label(null, __('models/userRole.fields.role_id').':') !!}
    {!! Form::select('role_id', $roleIdOptions, null, ['class' => 'form-control select2', 'data-column' => 'role_id']) !!}
</div>


<div class="form-group col-12">
    <!-- Role Id Field -->
    <div class="form-group col-sm-6" style="display: none">
        {!! Form::label(null, __('models/userRole.fields.role_id').':') !!}
        {!! Form::number('role_id', $roleId, ['class' => 'form-control', 'data-column' => 'role_id']) !!}
    </div>

    {!! Form::select('permission_id[]', $permissionOptions, null, [
        'class' => 'form-control duallistbox',
        'data-column' => 'permission_id',
        "multiple"=>"multiple",
        'id' => "permission_id"
        ]) !!}
</div>

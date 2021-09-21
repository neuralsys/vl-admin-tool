<div class='btn-group'>
    <button
        class='btn btn-danger btn-xs datatable-action'
        onclick="deleteRecord(this, '{{route("rolePermissions.destroy", "%s")}}', true, {
            key: 'permission_id',
            additionalAttrs: {
                'role_id': 'role_id'
            },
        })"
    >
        <i class="fas fa-trash-alt"></i>
    </button>
</div>

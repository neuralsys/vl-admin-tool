<div class='btn-group'>
    <a href="{{ route('rolePermissions.index', ["role_id" => $id]) }}" class='btn btn-default btn-xs datatable-action'>
        <i class="far fa-eye"></i>
    </a>

    <button class='btn btn-primary btn-xs datatable-action' onclick="editRecord(this, roleEditForm)">
        <i class="fas fa-edit"></i>
    </button>

    <button
        class='btn btn-danger btn-xs datatable-action'
        onclick="deleteRecord(this, '{{route("roles.destroy", "%s")}}', true, )"
    >
        <i class="fas fa-trash-alt"></i>
    </button>
</div>

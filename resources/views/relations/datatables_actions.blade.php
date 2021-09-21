<div class='btn-group'>
    <button class='btn btn-primary btn-xs datatable-action' onclick="editRecord(this, relationEditForm)">
        <i class="fas fa-edit"></i>
    </button>

    <button
        class='btn btn-danger btn-xs datatable-action'
        onclick="deleteRecord(this, '{{route("relations.destroy", "%s")}}', true, )"
    >
        <i class="fas fa-trash-alt"></i>
    </button>
</div>

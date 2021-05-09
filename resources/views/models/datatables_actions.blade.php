<div class='btn-group'>
    <button class='btn btn-primary btn-xs datatable-action' onclick="editRecord(this, modelEditForm)">
        <i class="fas fa-edit"></i>
    </button>

    <button
        class='btn btn-danger btn-xs datatable-action'
        onclick="deleteRecord(this, '{{route("models.destroy", "%s")}}', true, )"
    >
        <i class="fas fa-trash-alt"></i>
    </button>

    <button
        class='btn btn-primary btn-xs datatable-action'
        onclick="showGenerateModal(this)"
    >
        <i class="fas fa-cog"></i>
    </button>
</div>

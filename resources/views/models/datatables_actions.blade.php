<div class='btn-group'>
    <a href="{{ route('models.show', $id) }}" class='btn btn-default btn-xs datatable-action'>
        <i class="far fa-eye"></i>
    </a>

    <button class='btn btn-default btn-xs datatable-action' onclick="editRecord(this)">
        <i class="fas fa-edit"></i>
    </button>

    <button class='btn btn-default btn-xs datatable-action' onclick="deleteRecord(this)">
        <i class="fas fa-trash-alt"></i>
    </button>
</div>

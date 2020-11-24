<div class='btn-group'>
    <a href="{{ route('models.show', $id) }}" class='btn btn-default btn-xs datatable-action'>
        <i class="far fa-eye"></i>
    </a>

    <button class='btn btn-primary btn-xs datatable-action' onclick="editRecord(this, modelEditForm)">
        <i class="fas fa-edit"></i>
    </button>

    <button
        class='btn btn-danger btn-xs datatable-action'
        onclick="deleteRecord(this, '{{route("models.destroy", "%s")}}', true, {
            mainText: '@lang('crud.are_you_sure')',
            detailText: '@lang('crud.confirm_delete_text')',
            cancel: '@lang('crud.cancel')',
            agree: '@lang('crud.agree')',
            })"
    >
        <i class="fas fa-trash-alt"></i>
    </button>
</div>

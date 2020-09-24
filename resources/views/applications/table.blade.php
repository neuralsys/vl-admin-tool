<div class="table-responsive">
    <table class="table" id="applications-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Description</th>
        <th>Code</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($applications as $application)
            <tr>
                <td>{{ $application->name }}</td>
            <td>{{ $application->description }}</td>
            <td>{{ $application->code }}</td>
                <td>
                    {!! Form::open(['route' => ['applications.destroy', $application->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('applications.show', [$application->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('applications.edit', [$application->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

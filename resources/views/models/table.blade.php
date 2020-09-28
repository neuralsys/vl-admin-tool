@section('css')
    @include('vl-admin-tool::layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@push('scripts')
    @include('vl-admin-tool::layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush

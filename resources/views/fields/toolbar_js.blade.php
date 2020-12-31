@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.field-toolbar").html(`@include('fields.toolbar')`);
            }, 10)
        });
    </script>
@endpush

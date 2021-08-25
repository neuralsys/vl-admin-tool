@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.permission-toolbar").html(`@include('permissions.toolbar')`);
            }, 10)
        });
    </script>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.role-toolbar").html(`@include('roles.toolbar')`);
            }, 10)
        });
    </script>
@endpush

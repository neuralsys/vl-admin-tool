@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.rolePermission-toolbar").html(`@include('role_permissions.toolbar')`);
            }, 10)
        });
    </script>
@endpush

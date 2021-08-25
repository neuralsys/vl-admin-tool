@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.userRole-toolbar").html(`@include('user_roles.toolbar')`);
            }, 10)
        });
    </script>
@endpush

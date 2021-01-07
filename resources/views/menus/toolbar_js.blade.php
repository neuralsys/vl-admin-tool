@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.menu-toolbar").html(`@include('vl-admin-tool::menus.toolbar')`);
            }, 10)
        });
    </script>
@endpush

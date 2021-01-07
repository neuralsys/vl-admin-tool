@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.dBConfig-toolbar").html(`@include('vl-admin-tool::dBConfigs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.dBConfig-toolbar").html(`@include('vl-admin-tool::d_b_configs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

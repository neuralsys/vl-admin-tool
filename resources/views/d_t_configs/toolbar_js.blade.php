@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.dTConfig-toolbar").html(`@include('vl-admin-tool::d_t_configs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

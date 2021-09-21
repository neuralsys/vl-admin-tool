@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.cRUDConfig-toolbar").html(`@include('vl-admin-tool::c_r_u_d_configs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

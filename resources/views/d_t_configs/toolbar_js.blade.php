@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.dTConfig-toolbar").html(`@include('vl-admin-tool::dTConfigs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

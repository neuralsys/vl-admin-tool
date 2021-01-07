@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.cRUDConfig-toolbar").html(`@include('vl-admin-tool::cRUDConfigs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

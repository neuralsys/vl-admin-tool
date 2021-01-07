@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.dBConfig-toolbar").html(`@include('$NS_VIEW_PREFIX$dBConfigs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

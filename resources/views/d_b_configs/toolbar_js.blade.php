@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.dBConfig-toolbar").html(`@include('dBConfigs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.cRUDConfig-toolbar").html(`@include('cRUDConfigs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

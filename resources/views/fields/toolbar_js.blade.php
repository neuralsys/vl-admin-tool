@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.model-toolbar").html(`@include('vl-admin-tool::models.toolbar')`);
            }, 10)
        });
    </script>
@endpush

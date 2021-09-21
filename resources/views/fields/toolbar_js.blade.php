@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.field-toolbar").html(`@include('vl-admin-tool::fields.toolbar')`);
            }, 10)
        });
    </script>
@endpush

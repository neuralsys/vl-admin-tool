@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.relation-toolbar").html(`@include('vl-admin-tool::relations.toolbar')`);
            }, 10)
        });
    </script>
@endpush

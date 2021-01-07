@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.lang-toolbar").html(`@include('vl-admin-tool::langs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

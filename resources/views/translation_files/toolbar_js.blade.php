@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.translationFile-toolbar").html(`@include('vl-admin-tool::translationFiles.toolbar')`);
            }, 10)
        });
    </script>
@endpush

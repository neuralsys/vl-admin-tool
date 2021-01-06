@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.translationFile-toolbar").html(`@include('translationFiles.toolbar')`);
            }, 10)
        });
    </script>
@endpush

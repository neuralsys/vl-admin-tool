@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.lang-toolbar").html(`@include('langs.toolbar')`);
            }, 10)
        });
    </script>
@endpush

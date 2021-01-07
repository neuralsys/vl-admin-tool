@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setTimeout(() => {
                $("div.translation-toolbar").html(`@include('translations.toolbar')`);
            }, 10)
        });
    </script>
@endpush

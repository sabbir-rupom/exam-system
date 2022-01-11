<div id="preloader">
    <div id="status">
        <div class="spinner-chase">
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
            <div class="chase-dot"></div>
        </div>
    </div>
</div>
<input type="hidden" id="base_url" value="{{ url('/') }}">
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                @admin
                <p class="text-end">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Dikkha LMS
                </p>
                @else
                <p class="text-center">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Dikkha LMS
                </p>
                @endadmin
                </div>
        </div>
    </div>
</footer>

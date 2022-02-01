<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/toastr/toastr.min.js')}}"></script>
<script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/common.fn.min.js') . '?x=' . filemtime(public_path('assets/js/common.fn.min.js'))}}"></script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('assets/js/theme.min.js') . '?x=' . filemtime(public_path('assets/js/theme.min.js'))}}"></script>
<script src="{{ URL::asset('assets/js/app.min.js') . '?x=' . filemtime(public_path('assets/js/app.min.js'))}}"></script>

@admin
<script src="{{ URL::asset('assets/js/admin.min.js') . '?x=' . filemtime(public_path('assets/js/admin.min.js'))}}"></script>
@endadmin

@user
@enduser

@yield('script-bottom')

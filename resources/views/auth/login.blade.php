<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
{{--    <link href="{{url('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />--}}
{{--    <link href="{{url('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />--}}
    <link href="{{url('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{url('assets/css/app.css')}}" rel="stylesheet">
    <link href="{{url('assets/css/icons.css')}}" rel="stylesheet">
    <title>Ministry of Finance - Services Directorate</title>
</head>

<body class="bg-login">
<!--wrapper-->
<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center margbtn">
                                    <img src="assets/images/logo-icon.png">
                                    <h5>{{__('general_words.islamic_emirate')}}
                                    </h5>
                                    <p>
                                        {{__('general_words.ministry_of_finance')}} - {{__('general_words.services_directorate')}}</p>
                                </div>
                                <div class="form-body">
                                    <x-jet-validation-errors class="mb-4 text-danger text-center" />
                                    @if (session('status'))
                                        <div class="mb-4 font-medium text-sm text-green-600">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                        <form method="POST" class="row g-3" action="{{ route('login') }}" >
                                            @csrf
                                        <div class="col-12 mb-2">
                                            <div class="form-floating">
                                                <label for="inputEmailAddress" class="form-label label">{{__('general_words.email')}}</label>
                                                <input type="email" name="email" class="form-control" id="inputEmailAddress" placeholder="{{__('general_words.email')}}">
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-floating">
                                                <label for="inputChoosePassword" class="form-label label">{{__('general_words.password')}}</label>
                                                <div class="input-group" id="show_hide_password" style="flex-wrap: nowrap; height: calc(2.5rem + calc(var(--bs-border-width) * 2));">
                                                    <input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="{{__('general_words.password')}}">
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                        </div>
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="form-check form-switch">--}}
{{--                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>--}}
{{--                                                <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6 text-end">	<a href="authentication-forgot-password.html">Forgot Password ?</a>--}}
                                        </div>
                                        <div class="col-12 mt-4 mb-5">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open">{{__('general_words.login')}}</i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>
<!--end wrapper-->
<!-- Bootstrap JS -->
<script src="{{url('assets/js/bootstrap.bundle.min.js')}}"></script>
<!--plugins-->
<script src="{{url('assets/js/jquery.min.js')}}"></script>
<script src="{{url('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{url('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<!--Password show & hide js -->
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });

    localStorage.setItem('defaultDateType', 'jalali');
    setCookie('localStorageDateType', 'jalali', 7);
    function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
            }
</script>
<!--app JS-->
</body>
</html>
<style>
    .col-12 { direction: rtl;}
    .input-group:not(.has-validation) > .dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation) > :not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;}
    .input-group > :not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
        margin-left: unset;
        margin-right: -1px;
        border-top-right-radius: unset;
        border-bottom-right-radius: unset;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;}
    .border-end-0 {
  border-left: 0 !important;
  border-right:1px solid #ced4da !important;
}
.input-group:not(.has-validation) > .dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation) > :not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
}

</style>

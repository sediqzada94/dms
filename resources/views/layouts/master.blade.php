<!doctype html>
{{--<!-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> -->--}}
<html lang="prs" dir="rtl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--favicon-->

    <link rel="icon" href="{{asset('assets/images/favicon-32x32.png')}}" type="image/png"/>
    <!--plugins-->
    <link href="{{asset ('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset ('assets/plugins/notifications/css/lobibox.min.css')}}"/>
    <link href="{{asset ('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet"/>
    <link href="{{asset ('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet"/>
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{asset('assets/css/fontello.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{asset('assets/css/process.css') }}" rel="stylesheet">
    <link href="{{asset('assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{asset('css/vue-select.css') }}" rel="stylesheet" type="text/css"/>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css"
          rel="stylesheet">
          <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.6/dist/vue-multiselect.min.css">
    <style>
        [v-cloak] > * {
            display: none !important;
        }

        [v-cloak]::before {
            content: " ";
            display: block !important;

        }
    </style>
    <title>@yield('title')</title>
    <!--app JS-->
</head>

<body class="hold-transition sidebar-mini layout-fixed {{(App::isLocale('en') ? '' : 'rightcol')}}"
      dir="{{(App::isLocale('en') ? 'ltr' : 'rtl')}}">
<div class="wrapper toggled sidebar-hover" >
    <!--wrapper-->
    @include('layouts.navbar')
    @include('layouts.sidebar')
    @yield('content')
    @include('layouts.footer')
   

</div>    <!-- Bootstrap JS -->
<!-- Bootstrap JS -->
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<!--plugins-->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{asset('assets/js/app1.js') }}"></script>
<script src="https://unpkg.com/vue-multiselect@2.1.6"></script>


<script>
    $(function () {
        $('[data-bs-toggle="popover"]').popover();
        $('[data-bs-toggle="tooltip"]').tooltip();
    })
</script>
<!--notification js -->

<script src="{{asset('assets/plugins/notifications/js/lobibox.min.js')}}"></script>
<!-- @include('general_files.change_password') -->
  

<script>
    function setDefoultDate(dateType) {
            localStorage.setItem('defaultDateType', dateType);
            setCookie('localStorageDateType', dateType, 7);
            window.location.reload();
         }
         function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
            }
    function showMessage(message, type) {
        Swal.fire({
            icon: type,
            position: 'center',
            title: type==='warning'?message+'😒':message+'😍',
            showConfirmButton: false,
            timer: 1500
        })
    }


    function deleteItem(url,callbackFunction) {
        Swal.fire({
            title: "{{ __('general_words.are_you_sure')}}",
            text: "{{ __('general_words.wont_be_to_revert')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonText: "{{ __('general_words.cancel_it')}}",
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('general_words.yes_delete')}}"
        }).then((result) => {
            if (result.isConfirmed) {
                axios.delete(url, {}).then((response) => {
                    let res = response.data;
                    if (res.status == 200) {
                        if(callbackFunction){
                            callbackFunction();
                        }else{
                            vm.getRecord();
                        }
                        showMessage(res.message, 'success')
                    } else {
                        showMessage(res.message, 'warning')
                    }
                })
            } else {
                Swal.fire(
                    "{{ __('general_words.not_deleted')}}",
                    "{{ __('general_words.record_is_safe')}}",
                    'success'
                )
            }
        })
    }
    function hasFlowPermission(table,id)
    {
        let flow =null;
        axios.get('/checkFlowPermission'+'?table='+table+'&id='+id).then(res => {
            flow =res.data;
            return res.data;
        })
    }
     function confirmFlow(table,table_id,flow){
        return new Promise((resovle, reject) => {
            Swal.fire({
                title: '{{ __("general_words.are_you_sure") }}',
                input: 'text',
                inputLabel: '{{ __("general_words.remark") }}',
                inputValue: '',
                showCancelButton: true,
                confirmButtonText: '{{ __("general_words.yes") }}',
                cancelButtonText: '{{ __("general_words.no") }}',
                inputValidator: (value) => {
                 remark = value;
                }
              }).then((result) => {
                  if(result.isConfirmed){
                    axios.post('/flow' + '?table=' + table + '&flow=' + flow+'&table_id='+table_id + "&remark="+remark)
                    .then((res) => {
                        let response = res.data;
                        if (response.status ==200) {
                            resovle(response.flow)
                            latestFlow=response.flow;
                            showMessage('{{ __("general_words.done") }}', 'success');
                        }
                        else {
                            reject()
                            showMessage(response.message, 'warning');
                        }
                })
                  }
              })
    })
    }
    function curDate() {
        return '{!!currentDate()!!}';
    }
</script>
@yield('scripts')


</body>
</html>

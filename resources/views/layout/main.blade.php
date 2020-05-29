<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('assets/font/css/all.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/jquery.scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/axios-loader.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/notiflix-2.1.3.min.css')}}" rel="stylesheet">
    @yield('style')
</head>
<body>
@yield('content')
<script src="{{asset('assets/js/jquery-latest.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/js/jquery.scrollbar.js')}}"></script>
<script src="{{asset('assets/js/axios.min.js')}}"></script>
<script src="{{asset('assets/js/axios-loader.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.scrollbar-inner').scrollbar();
    });
    loadProgressBar();
</script>
<script src="{{asset('assets/js/notiflix-2.1.3.min.js')}}"></script>
@yield('script')
</body>

</html>

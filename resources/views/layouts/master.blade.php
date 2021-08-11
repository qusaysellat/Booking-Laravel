<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ URL::to('public/css/main.css') }}" rel="stylesheet">
    <script src="{{ asset('public/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap.js') }}"></script>
    <script src="{{ asset('public/js/main.js') }}"></script>
</head>
<body>
<script>
    var searchurl='{{route('searchAjax')}}';
    var token = '{{ Session::token() }}';
</script>

    <div id='wrapper'>
        @include('includes.sidebar')
        <div id="page-wrapper">
            <div id="page-inner">
                @include('includes.error_section')
                @yield('content')
            </div>
        </div>
    </div>
    @include('includes.footer')



</body>
</html>

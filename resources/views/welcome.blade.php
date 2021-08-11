<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
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
    var searchurl = '{{route('searchAjax')}}';
    var token = '{{ Session::token() }}';
</script>
<div class="signin">
    <div class="signin-fields">
        <div class="container-fluid">
            <div class="">
                @include('includes.error_section')
                <p class="lead text-center"></p>
                <div class="">
                    <form action="{{ route('signin') }}" method="post" role="form">
                        <div class="form-group">
                            <input class="form-control input-lg" type="email" name="email" id="email0" required
                                   value="" placeholder="{{trans('admin.email')}}">
                        </div>
                        <div class="form-group">
                            <input class="form-control input-lg" type="password" name="password" id="password0"
                                   value="" placeholder="{{trans('admin.pw')}}">
                        </div>
                        <button class="btn btn-success btn-lg center-block mybutton" type="submit">{{trans('admin.signin')}}</button>
                        <input type="hidden" name="_token" value={{ Session::token() }}>
                    </form>
                    <p class="lead">
                        {{trans('admin.welcome')}} <a class="brand" href="{{ route('presignup') }}">{{trans('admin.signup')}}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


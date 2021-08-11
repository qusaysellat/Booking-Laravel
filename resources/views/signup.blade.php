<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
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
<div class="signup">
    <div class="signup-fields">
        <div class="container-fluid">
            <div class="">
                @include('includes.error_section')
                <p class="lead text-center"></p>
                <p class="lead">
                    {{trans('admin.have_an_account')}} <a class="brand" href="{{{ route('login') }}}">{{trans('admin.signin')}}
                        </a>
                </p>
                <div class="">
                    <form id='form' action="{{ route('postsignup') }}" method="post" enctype="multipart/form-data"
                          role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{trans('admin.email')}} *</label>
                                    <input class="form-control" type="email" name="email" id="email" placeholder="" required
                                           value='{{ Request::old('email') }}'>
                                </div>
                                <div class="form-group">
                                    <label for="password">{{trans('admin.pw')}} *</label>
                                    <input class="form-control" type="password" name="password" id="password" placeholder="" required
                                           value=''>
                                </div>
                                <div class="form-group">
                                    <label for="username">{{trans('admin.un')}} *</label>
                                    <input class="form-control" type="text" name="username" id="username" placeholder=""
                                           value='{{ Request::old('username') }}'>
                                </div>
                                <div class="form-group">
                                    <label for="type">{{trans('admin.category')}} *</label>
                                    <select name="type" id="type" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="city">{{trans('admin.city')}} *</label>
                                    <select name="city" id="city" class="form-control">
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">{{trans('admin.address')}}</label>
                                    <textarea class="form-control" rows="1" name="address" id="address"
                                              placeholder="">{{ Request::old('address') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="cemail">{{trans('admin.cemail')}}</label>
                                    <input class="form-control" type="text" name="cemail" id="cemial" placeholder=""
                                           value='{{ Request::old('cemial') }}'>
                                </div>
                                <div class="form-group">
                                    <label for="phone1">{{trans('admin.phone1')}}</label>
                                    <input class="form-control" type="text" name="phone1" id="phone1" placeholder=""
                                           value='{{ Request::old('phone1') }}'>
                                </div>
                                <div class="form-group">
                                    <label for="phone2">{{trans('admin.phone2')}}</label>
                                    <input class="form-control" type="text" name="phone2" id="phone2" placeholder=""
                                           value='{{ Request::old('phone2') }}'>
                                </div>
                                <div class="form-group">
                                    <label for="website">{{trans('admin.website')}}</label>
                                    <input class="form-control" type="text" name="website" id="website" placeholder=""
                                           value='{{ Request::old('website') }}'>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="robot" id="robot">
                                    <label for="user_name"></label>
                                    <input type="text" name="user_name" id="user_name" value="">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{trans('admin.desc')}}</label>
                                    <textarea class="form-control" rows="5" name="description" id="description"
                                              placeholder="">{{ Request::old('description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="image">{{trans('admin.pimage')}}</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
                                <button class="btn btn-success mybutton center-block" type="submit" id="submitform">{{trans('admin.signup')}}
                                </button>
                                <input type="hidden" name="_token" value={{ Session::token() }}>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


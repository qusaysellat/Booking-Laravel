<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="adjust-nav">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('dashboard')}}">Booking.com</a>
        </div>

        <div class="navbar-collapse collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">

            @if(Auth::user())
                    <li>
                        <form class="navbar-form" role="search" method="get" action={{route('search')}}>
                            <div class="input-group">
                                <div>
                                    <input type="text" class="form-control" placeholder="Search.." name="token"
                                           id="search" autocomplete="off">
                                    <div id="livesearch"></div>
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-search fa-lg"></i>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </li>
                    <li><a href= {{ route('seenotifications') }} ><i class="fa fa-globe"> </i>{{trans('admin.nots')}} </a>
                    </li>
                    <li><a href="{{route('getuser',['username'=>Auth::user()->username])}}"><i class="fa fa-cog"></i>{{trans('admin.my_profile')}}</a></li>
                    <li><a href= {{ route('signout') }} ><i class="fa fa-sign-out"></i> {{trans('admin.signout')}}</a></li>
            @else
                    <li>
                        <form class="navbar-form" role="search" method="get" action={{route('search')}}>
                            <div class="input-group">
                                <div>
                                    <input type="text" class="form-control" placeholder="Search.." name="token"
                                           id="search" autocomplete="off">
                                    <div id="livesearch"></div>
                                </div>
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="submit"><i class="fa fa-search fa-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li><a href= {{ route('presignup') }} ><i class="fa fa-user-plus"></i> {{trans('admin.signup')}}</a></li>
                    <li><a href= {{ route('login') }} ><i class="fa fa-sign-in"></i>{{trans('admin.signin')}}</a></li>
            @endif
                <li class="dropdown" style="margin-top: 20px;">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        {{App::getLocale()}}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" style="width:15px; text-align: right;" aria-labelledby="dropdownMenu1">
                        <li><a href="{{route('lang',['lang'=>'en'])}}">English</a></li>
                        <li><a href="{{route('lang',['lang'=>'fr'])}}">Français</a></li>
                        <li><a href="{{route('lang',['lang'=>'ar'])}}">العربية</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /. NAV TOP  -->


<div class="ads">
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse ">
            <ul class="nav" id="main-menu">
                @if(isset($advs[1]))
                    <li>
                        <div>
                            <p class="label label-danger">ADS</p>
                            @if($advs[1]->title<>'no')
                                <p class="text-center h4"> {{$advs[1]->title}}</p>
                            @endif
                            <p class="">{{$advs[1]->content}}</p>
                            <img
                                    class="adimage center-block img-circle"
                                    src="{{ route('adimage', ['id' => $advs[1]->id]) }}"
                                    hover="sfsfsf">
                        </div>
                    </li>
                @endif

                @if(isset($advs[2]))
                    <li>
                        <div>
                            <p class="label label-danger">ADS</p>
                            @if($advs[2]->title<>'no')
                                <p class="text-center h4"> {{$advs[2]->title}}</p>
                            @endif
                            <p class="">{{$advs[2]->content}}</p>
                            <img
                                    class="adimage center-block img-circle"
                                    src="{{ route('adimage', ['id' => $advs[2]->id]) }}"
                                    alt="">
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</div>


{{--
@if(Auth::user())
<div class="">
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse ">

                <li class="text-center user-image-back">
                    <a href='#'>

                    </a>
                </li>


                <li>
                    <a href="#"><i class="fa fa-caret-right"> Main Page</i></a>
                </li>



                <li><a href= "#" ><i class="fa fa-caret-right"> Related Users</i></a></li>
                <li><a href= "#"  ><i class="fa fa-caret-right"> Explore Users</i></a></li>
                <li><a href= "#"  ><i class="fa fa-caret-right"> My Messages</i></a></li>
            </ul>
        </div>
    </nav>
</div>
@endif
--}}

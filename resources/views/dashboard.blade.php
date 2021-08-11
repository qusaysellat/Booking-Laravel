@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container-fluid">

        {{--<p class="h2 text-center">{{$explanation}} <br/> {{$category}}-{{$city}}</p> --}}

        <div class="row ">
            <div class="col-sm-offset-1 col-sm-4">
                <div class="dropdown">
                    <button class="btn btn-info btn-block dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        {{$category}}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="{{ route('configureddashboard',['category_id'=>0,'city_id'=>$city_id]) }}">{{trans('admin.all_categories')}}</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($categories as $category)
                            @if($category->id<>1)
                            <li>
                                <a href="{{ route('configureddashboard',['category_id'=>$category->id,'city_id'=>$city_id]) }}">{{$category->name}}</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-4">
                <div class="dropdown">
                    <button class="btn btn-info btn-block dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        {{$city}}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="{{ route('configureddashboard',['category_id'=>$category_id,'city_id'=>0]) }}">{{trans('admin.all_cities')}}</a></li>
                        <li role="separator" class="divider"></li>
                        @foreach($cities as $city)
                            <li>
                                <a href="{{ route('configureddashboard',['category_id'=>$category_id,'city_id'=>$city->id]) }}">{{$city->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <hr/>
    </div>


    <div class="container-fluid">

        <?php $i = 0?>
        @foreach ($users as $user)
            @if($i%3==0)
                <div class="row">
                    @endif
                    <div class="col-lg-4">
                        <div class="user-show">
                            <div class="media">
                                <div class="media-left">
                                    <br/>
                                    <img
                                            class="myimage"
                                            src="{{ route('profileimage', ['id' => $user->id]) }}"
                                            alt="">

                                </div>
                                <div class="media-body">
                                    <a href="{{route('getuser',['username'=>$user->username])}}">
                                        <h4 class="media-heading"> {{$user->username}}</h4>
                                    </a>
                                    <div class="">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p class="mydate">{{$user->category->name}} , {{$user->city->name}}</p>
                                                @if(strlen($user->description))
                                                    <p class="mydescription">{{str_limit($user->description,80," ...")}}</p>
                                                @endif
                                                <i class="fa fa-user"><a
                                                            href="{{route('getuser',['username'=>$user->username])}}">
                                                        {{trans('admin.see_more')}}</a> </i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($i%3==2)
                </div>
            @endif
            <?php $i++?>
        @endforeach

    </div>

@endsection
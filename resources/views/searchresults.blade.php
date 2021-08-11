@extends('layouts.master')
@section('title')
    Search Results
@endsection
@section('content')
    <h1>Search Results For " {{$token}} "</h1>
    <div class="container-fluid">
        <div class="row">
            @foreach ($users as $user)
                <div class="col-xs-12">
                    <div class="user-show">
                        <div class="media">
                            <div class="media-left">
                                <img
                                        class="myimage"
                                        src="{{ route('profileimage', ['id' => $user->id]) }}"
                                        alt="">

                            </div>
                            <div class="media-body">
                                <a href="{{route('getuser',['username'=>$user->username])}}">
                                    <h4 class="media-heading">{{$user->username}}</h4>
                                </a>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p class="mydate">{{$user->category->name}} , {{$user->city->name}}</p>
                                        @if(strlen($user->description))
                                            <p class="mydescription">{{$user->description}}</p>
                                        @endif
                                        <i class="fa fa-user"><a
                                                    href="{{route('getuser',['username'=>$user->username])}}"> See
                                                Profile</a> </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
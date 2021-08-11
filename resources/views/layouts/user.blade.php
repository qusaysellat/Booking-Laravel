@extends('layouts.master')
@section('title')
    {{$user->username}} Profile
@endsection
@section('content')
    <div class="container-fluid">

        <img
                class="userimage center-block"
                src="{{ route('profileimage', ['id' => $user->id]) }}"
                alt="">


        <h1 class="text-center">
            {{$user->username}}
        </h1>
        @if($user->images()->count()>0)
             @include('includes.carousel')
        @endif

        @if(!$guest && Auth::user()->id==$user->id && $user->images()->count()<5)
            <hr/>
            <form id='form' action="{{ route('addImage') }}" method="post" enctype="multipart/form-data"
                  role="form">
                <div class="row">
                    <div class="col-md-6">
                        <label for="image">add image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <br/>
                        <button class="btn btn-primary s mybutton " type="submit"
                                id="submitform">{{trans('admin.save')}}
                        </button>
                    </div>
                    <input type="hidden" name="_token" value={{ Session::token() }}>
                </div>
            </form>
        @endif
        <hr/>

        <div class="personal">
            <div class="row">

                <div class="col-md-4">
                    <i class="fa fa-tags fa-lg">&ensp;{{trans('admin.category')}} </i>
                </div>
                <div class="col-md-8">
                    <p class="">
                        {{$user->category->name}}
                    </p>
                </div>
                <div class="col-md-4">
                    <i class="fa fa-home fa-lg">&ensp;{{trans('admin.city')}} </i>
                </div>
                <div class="col-md-8">
                    <p class="">
                        {{$user->city->name}}
                    </p>
                </div>
                @if(strlen($user->address))
                    <div class="col-md-4">
                        <i class="fa fa-map-marker fa-lg">&ensp;{{trans('admin.address')}} </i>
                    </div>
                    <div class="col-md-8">
                        <p class="">
                            {{$user->address}}
                        </p>
                    </div>
                @endif
                @if(strlen($user->phone1))
                    <div class="col-md-4">
                        <i class="fa fa-phone fa-lg">&ensp;{{trans('admin.phone1')}} </i>
                    </div>
                    <div class="col-md-8">
                        <p class="">
                            {{$user->phone1}}
                        </p>
                    </div>
                @endif
                @if(strlen($user->phone2))
                    <div class="col-md-4">
                        <i class="fa fa-phone fa-lg">&ensp;{{trans('admin.phone2')}} </i>
                    </div>
                    <div class="col-md-8">
                        <p class="">
                            {{$user->phone2}}
                        </p>
                    </div>
                @endif
                @if(strlen($user->contactemail))
                    <div class="col-md-4">
                        <i class="fa fa-envelope fa-lg">&ensp;{{trans('admin.cemail')}} </i>
                    </div>
                    <div class="col-md-8">
                        <p class="">
                            {{$user->contactemail}}
                        </p>
                    </div>
                @endif
                @if(strlen($user->website))
                    <div class="col-md-4">
                        <i class="fa fa-cloud fa-lg">&ensp;{{trans('admin.website')}} </i>
                    </div>
                    <div class="col-md-8">
                        <p class="">
                            {{$user->website}}
                        </p>
                    </div>
                @endif
                @if (strlen($user->description))
                    <div class="col-md-4">
                        <i class="fa fa-pencil fa-lg">&ensp;{{trans('admin.desc')}} </i>
                    </div>
                    <div class="col-md-8">
                        <p class="">
                            {!! nl2br(e($user->description)) !!}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <hr/>
    @yield('morecontent')
@endsection
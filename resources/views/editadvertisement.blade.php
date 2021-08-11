@extends('layouts.adminlayout')
@section('title')
    Manage Advertisements
@endsection
@section('content')
    <div class="container-fluid">
        <p class="h1">Edit {{$ad->title}}</p>
        <p class="lead"><a href="{{route('newadvertisement')}}">return to advertisements</a></p>
        <hr/>
        <form action="{{route('posteditadvertisement')}}" method="post" enctype="multipart/form-data"
              role="form">
            <div class="form-group">
                <label for="title">Write A Title For This Ad * (if no tiltle just enter 'no')</label>
                <input class="form-control" type="text" name="title" id="title"
                       value='{{ $ad->title }}'>
            </div>
            <div class="form-group">
                <label for="content">You Can Write About This Ad (max=200 characters)</label>
                <textarea class="form-control" rows="5" name="content"
                          id="content">{{$ad->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="importance">How Important Is This Ad? (1-100)</label>
                <input class="form-control" type="text" name="importance" id="importance"
                       value='{{ $ad->importance }}'>
            </div>
            <div class="form-group">
                <label for="image">You Can Add An Image To This Ad</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>
            <img
                    class="adimage center-block img-circle"
                    src="{{ route('adimage', ['id' => $ad->id]) }}"
                    alt="">
            <input type="hidden" name="id" value= {{$ad->id}} >
            <br/>
            <button class="btn btn-success mybutton center-block" type="submit">Save</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>
@endsection
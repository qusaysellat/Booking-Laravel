@extends('layouts.adminlayout')
@section('title')
    Manage Cities
@endsection
@section('content')
    <div class="container-fluid">
        <p class="h1">Edit {{$city->name}} City</p>
        <p class="lead"><a href="{{route('managecities')}}">return to cities</a></p>
        <hr/>
        <form action="{{route('posteditcity')}}" method="post">
            <div class="form-group">
                <label for="name">City Name</label>
                <input class="form-control" type="text" name="name" id="name"
                       value='{{$city->name}}'>
            </div>
            <input type="hidden" name="id" value= {{ $city->id }} >
            <button class="btn btn-success center-block mybutton" type="submit">Save</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>
@endsection
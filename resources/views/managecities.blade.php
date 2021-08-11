@extends('layouts.adminlayout')
@section('title')
    Manage Cities
@endsection
@section('content')
    <div class="container-fluid">
        <h1>Manage Cities</h1>
        <p class="lead"><a href="{{route('adminpanel')}}">return</a> to main admin panel</p>
        <hr/>
        <p class="lead text-center">This is a list of current cities in the website</p>
        <table class="table table-bordered table-condensed  table-striped table-responsive">
            <thead>
            <tr>
                <th>City Name</th>
                <th>Options</th>
            </tr>
            </thead>
            @foreach($cities as $city)
                <tr>
                    <td>{{$city->name}}</td>
                    <td><a href="{{route('editcity',['id'=>$city->id])}}">Edit</a></td>
                </tr>
            @endforeach
        </table>
        <hr/>
        <p class="lead text-center">You Are Allowed To Add New Cities</p>
        <form action="{{route('newcity')}}" method="post">
            <div class="form-group">
                <label for="name">City Name</label>
                <input class="form-control" type="text" name="name" id="name"
                       value='{{ Request::old('name') }}'>
            </div>
            <button class="btn btn-success mybutton center-block" type="submit">Save</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>

@endsection
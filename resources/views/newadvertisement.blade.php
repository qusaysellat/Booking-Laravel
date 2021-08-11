@extends('layouts.adminlayout')
@section('title')
    Manage Advertisements
@endsection
@section('content')
    <div class="container-fluid">
        <h1>Manage Advertisements</h1>
        <p class="lead"><a href="{{route('adminpanel')}}">return</a> to main admin panel</p>
        <hr/>
        <p class="lead text-center">New Advertisement</p>
        <form action="{{route('makeadvertisement')}}" method="post" enctype="multipart/form-data"
              role="form">
            <div class="form-group">
                <label for="title">Write A Title For This Ad * (if no tiltle just enter 'no')</label>
                <input class="form-control" type="text" name="title" id="title"
                       value='{{ Request::old('title') }}'>
            </div>
            <div class="form-group">
                <label for="content">You Can Write About This Ad (max=200 characters)</label>
                <textarea class="form-control" rows="2" name="content"
                          id="content">{{ Request::old('content') }}</textarea>
            </div>
            <div class="form-group">
                <label for="importance">How Important Is This Ad? (1-100)</label>
                <input class="form-control" type="text" name="importance" id="importance"
                       value='{{ Request::old('importance') }}'>
            </div>
            <div class="form-group">
                <label for="image">You Can Add An Image To This Ad</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>
            <button class="btn btn-success mybutton center-block" type="submit">Save</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>
<hr/>
    <div class="container-fluid">
        <br>
        <p class="lead text-center">This Is A List Of Advertisements In The Website</p>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ad Title</th>
                <th>Ad Content</th>
                <th>Ad Importance</th>
                <th>Has Image?</th>
                <th>Creation Date</th>
                <th>Activate/Disactivate</th>
                <th>Options</th>
            </tr>
            </thead>
            @foreach($ads as $ad)
                <tr>
                    <td>{{$ad->id}}</td>
                    <td>{{$ad->title}}</td>
                    <td>{{$ad->content}}</td>
                    <td>{{$ad->importance}}</td>
                    @if($ad->picname)
                        <td>YES</td>
                    @else
                        <td>NO</td>
                    @endif
                    <td>{{$ad->created_at}}</td>
                    <td><a href={{route('activatead',['id'=>$ad->id])}}>
                            @if($ad->available)
                                Disactivate
                            @else
                                Activate
                            @endif
                        </a></td>
                    <td><a href="{{route('editadvertisement',['id'=>$ad->id])}}">Edit</a> </td>
                    <td><a href="{{route('deleteadvertisement',['id'=>$ad->id])}}"><i class="fa fa-trash fa-2x"></i></a> </td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
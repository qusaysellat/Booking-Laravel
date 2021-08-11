@extends('layouts.adminlayout')
@section('title')
    Read Contacts
@endsection
@section('content')
    <div class="container-fluid">
        <p class="h1">Reply Contact</p>
        <p class="lead"><a href="{{route('readcontactus')}}">return to contacts</a></p>
        <hr/>
        <p class="lead">From : {{$cu->user->username}}</p>
        <p class="lead">Subject : {{$cu->subject}}</p>
        <p class="lead">Content : {{$cu->content}}</p>
        <form action="{{route('editcontactus')}}" method="post">
            <div class="form-group">
                <label for="reply">Write The Reply Here *</label>
                <textarea class="form-control" rows="5" name="reply" id="reply">{{{ Request::old('reply') }}}</textarea>
            </div>
            <input type="hidden" name="id" value= {{ $cu->id }} >
            <button class="btn btn-success center-block mybutton" type="submit">Save</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>
@endsection
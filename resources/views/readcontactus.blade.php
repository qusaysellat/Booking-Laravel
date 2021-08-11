@extends('layouts.adminlayout')
@section('title')
    Read Contacts
@endsection
@section('content')
    <div class="container-fluid">
        <h1>Read Contacts</h1>
        <p class="lead"><a href="{{route('adminpanel')}}">return</a> to main admin panel</p>
        <hr/>
        <p class="lead text-center">list of current categories in the website</p>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>From</th>
                <th>Subject</th>
                <th>Content</th>
                <th>Reply</th>
                <th>Contact Date</th>
            </tr>
            </thead>
            @foreach($cu as $c)
                <tr>
                    <td>{{$c->id}}</td>
                    <td>{{$c->user->username}}</td>
                    <td>{{$c->subject}}</td>
                    <td>{{$c->content}}</td>
                    <td>
                        @if(strlen($c->reply))
                            {{$c->reply}}
                        @else
                            NO REPLY. <a href="{{route('replycontactus',['id'=>$c->id])}}">Reply Now</a>
                        @endif
                    </td>
                    <td>{{$c->created_at}}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
@extends('layouts.master')
@section('title')
    My Notifications
@endsection
@section('content')
    <div class="container-fluid">
        <br/>
        <p class="lead text-center">{{trans('admin.nots')}}</p>
        <table class="table  table-bordered table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>{{trans('admin.content')}}</th>
                <th>{{trans('admin.creation_date')}}</th>
                <th>{{trans('admin.notes')}}</th>
            </tr>
            </thead>
            @foreach($notifications as $notification)
                <tr>
                    <td>
					@if($notification->read==0)
                        <p class="label label-success">new</p>
                    @endif
					{{$notification->content}}
					</td>
                    <td>{{$notification->created_at}}</td>
                    <td>
                        @if(strlen($users[$notification->id])>1)
                            <a href={{route('getuser',['username'=>$users[$notification->id]])}}>See Profile</a>
                    @else
                        NO
                    @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
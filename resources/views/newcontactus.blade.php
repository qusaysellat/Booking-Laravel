@extends('layouts.master')
@section('title')
    Contact Us
@endsection
@section('content')
    <div class="container-fluid">
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>{{trans('admin.subject')}}</th>
                <th>{{trans('admin.content')}}</th>
                <th>{{trans('admin.reply')}}</th>
                <th>{{trans('admin.creation_date')}}</th>
            </tr>
            </thead>
            @foreach($cu as $c)
                <tr>
                    <td>{{$c->subject}}</td>
                    <td>{{$c->content}}</td>
                    <td>{{$c->reply}}</td>
                    <td>{{$c->created_at}}</td>
                </tr>
            @endforeach
        </table>
    </div>


@endsection
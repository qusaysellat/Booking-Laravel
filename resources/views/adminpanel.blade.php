@extends('layouts.adminlayout')
@section('title')
    Admin Panel
@endsection
@section('content')
    <div class="container-fluid">
        <br/>
        <p class="h1">Welcome To Admin Panel</p>
        <hr/>
        <p class="lead">What Do You Want To Do?</p>
        <a href="{{route('manageusers')}}">
            <i class="fa fa-caret-right fa-3x"> Manage Users And Payments </i>
        </a>
        <br/>
        <a href="{{route('managecategories')}}">
            <i class="fa fa-caret-right fa-3x"> Manage Categories </i>
        </a>
        <br/>
        <a href="{{route('managecities')}}">
            <i class="fa fa-caret-right fa-3x"> Manage Cities</i>
        </a>
        <br/>
        <a href="{{route('newadvertisement')}}">
            <i class="fa fa-caret-right fa-3x"> Manage Advertisements</i>
        </a>
        <br/>
        <a href="{{route('readcontactus')}}">
            <i class="fa fa-caret-right fa-3x"> Read Contacts</i>
        </a>
    </div>
@endsection
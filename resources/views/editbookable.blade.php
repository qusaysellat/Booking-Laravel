@extends('layouts.master')
@section('title')
    {{$bookable->name}}
@endsection
@section('content')
    <div class="container-fluid">
        <p class="lead text-center">{{trans('admin.allowed_to_edit')}}</p>
        <form action="{{route('posteditbookable')}}" method="post">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">{{trans('admin.item_name')}}</label>
                        <input class="form-control" type="text" name="name" id="name" required
                               value='{{ $bookable->name }}'>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <label for="number">{{trans('admin.available')}}</label>
                        <input class="form-control" type="text" name="number" id="number" required
                               value='{{ $bookable->number }}'>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <label for="price">{{trans('admin.price')}}</label>
                        <input class="form-control" type="text" name="price" id="price" required
                               value='{{$bookable->price }}'>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">{{trans('admin.desc')}}</label>
                <textarea class="form-control" rows="3" name="description" id="description">{{$bookable->description}}</textarea>
            </div>
            <input type="hidden" name="id" value= {{ $bookable->id }} >
            <button class="btn btn-success mybutton center-block" type="submit">{{trans('admin.save')}}</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>
@endsection
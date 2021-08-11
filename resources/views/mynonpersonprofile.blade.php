@extends('layouts.user')
@section('morecontent')
    <div class="container-fluid">
        <button class=" toggle-button btn mybutton center-block btn-primary" >{{trans('admin.bookables')}}
        <i class="fa fa-caret-down"></i> </button>
        <div class="toggle-class">
        @foreach($user->bookables as $bookable)
            <div class="bookable">
                <div class="row">
                    <div class="col-md-4">
                        <p class="">
                            <i class="fa fa-star fa-lg"></i>&ensp;
                            {{$bookable->name}}
                        </p>
                    </div>
                    @if(strlen($bookable->description))
                        <div class="col-md-4">
                            <p>
                                <i class="fa fa-pencil fa-lg"></i> &ensp;{{$bookable->description}}
                            </p>
                        </div>
                    @endif
                    <div class="col-md-2">
                        <p>
                            <i class="fa fa-money fa-lg"></i>&ensp;{{$bookable->price}} S.P.
                        </p>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('deletebookable',['id'=>$bookable->id])}}">
                            <i class="fa fa-trash fa-3x"></i>
                        </a>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{route('editbookable',['id'=>$bookable->id])}}">
                            <button class="btn btn-block btn-info"> {{trans('admin.edit')}} {{$bookable->name}}</button>
                        </a>
                    </div>
                    <div class="col-md-offset-1 col-md-3">
                        <a href="{{route('managebookable',['id'=>$bookable->id])}}">
                            <button class="btn btn-block btn-info">{{trans('admin.manage_booking')}}</button>
                        </a>
                    </div>
                    <div class="col-md-offset-1 col-md-3">
                        <a href="{{route('newoffer',['id'=>$bookable->id])}}">
                            <button class="btn btn-block btn-info">{{trans('admin.make_offer')}}</button>
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
        </div>
    </div>
    <hr/>
    <div class="container-fluid">
        <p class="lead text-center">{{trans('admin.add_items')}}</p>
        <form action="{{route('newbookable')}}" method="post">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">{{trans('admin.item_name')}}</label>
                        <input class="form-control" type="text" name="name" id="name" required
                               value='{{ Request::old('name') }}'>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <label for="number">{{trans('admin.available')}}</label>
                        <input class="form-control" type="text" name="number" id="number" required
                               value='{{ Request::old('number') }}'>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="form-group">
                        <label for="price">{{trans('admin.price')}}</label>
                        <input class="form-control" type="text" name="price" id="price" required
                               value='{{ Request::old('price') }}'>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">{{trans('admin.desc')}}</label>
                <textarea class="form-control" rows="3" name="description"
                          id="description">{{ Request::old('description') }}</textarea>
            </div>
            <button class="btn btn-info center-block mybutton" type="submit">{{trans('admin.save')}}</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>

@endsection
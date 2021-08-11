@extends('layouts.adminlayout')
@section('title')
    Manage Categories
@endsection
@section('content')
    <div class="container-fluid">
        <p class="h1">Edit {{$category->name}} Category</p>
        <p class="lead"><a href="{{route('managecategories')}}">return to categories</a></p>
        <hr/>
        <form action="{{route('posteditcategory')}}" method="post">
            <div class="form-group">
                <label for="name">Category Name</label>
                <input class="form-control" type="text" name="name" id="name"
                       value='{{ $category->name }}'>
            </div>
            <div class="form-group">
                <label for="pay">Annual Payment (*1000)</label>
                <input class="form-control" type="text" name="pay" id="pay"
                       value='{{$category->annualpayment }}'>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" rows="5" name="description"
                          id="description">{{ $category->description }}</textarea>
            </div>
            <input type="hidden" name="id" value= {{ $category->id }} >
            <button class="btn btn-success center-block mybutton" type="submit">Save</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>

@endsection
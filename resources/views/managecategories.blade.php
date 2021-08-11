@extends('layouts.adminlayout')
@section('title')
    Manage Categories
@endsection
@section('content')
    <div class="container-fluid">
        <h1>Manage Categories</h1>
        <p class="lead"><a href="{{route('adminpanel')}}">return</a> to main admin panel</p>
        <hr/>
        <p class="lead text-center">This is a list of current categories in the website</p>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>Category Name</th>
                <th>Annual Payment (*1000)</th>
                <th>Description</th>
                <th>Options</th>
            </tr>
            </thead>
            @foreach($categories as $category)
                <tr>
                    <td>{{$category->name}}</td>
                    <td>{{$category->annualpayment}}</td>
                    <td>{{$category->description}}</td>
                    <td><a href="{{route('editcategory',['id'=>$category->id])}}">Edit</a></td>
                </tr>
            @endforeach
        </table>
        <hr/>
        <p class="lead text-center">You Are Allowed To Add New Categories</p>
        <form action="{{route('newcategory')}}" method="post">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input class="form-control" type="text" name="name" id="name"
                               value='{{ Request::old('name') }}'>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="pay">Annual Payment (*1000)</label>
                        <input class="form-control" type="text" name="pay" id="pay"
                               value='{{ Request::old('pay') }}'>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" rows="5" name="description"
                          id="description">{{ Request::old('description') }}</textarea>
            </div>
            <button class="btn btn-success mybutton center-block" type="submit">Save</button>
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>
@endsection
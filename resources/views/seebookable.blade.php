@extends('layouts.master')
@section('title')
    {{$bookable->name}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <p class="h2">
                    {{$bookable->name}} , {{$bookable->user->username}}
                </p>
            </div>
            @if(strlen($bookable->description))
                <div class="col-md-12">
                    <i class="fa fa-pencil fa-lg"></i> &ensp;{{$bookable->description}}

                </div>
            @endif
            <div class="col-md-12">
                <i class="fa fa-money fa-lg"></i>&ensp;Price For One Place Is {{$bookable->price}} S.P.
            </div>
        </div>
        <p class="lead"><a href="{{route('getuser',['username'=>$bookable->user->username])}}">Return</a> </p>
<hr/>

        <p class="lead text-center">{{trans('admin.book_availabe')}}</p>
        <form action="{{route('book')}}" method="post">
            <div class="row">
                <div class="col-sm-offset-2 col-sm-6">
            <div class="form-group">
                <input class="form-control" type="date" min={{date("Y-m-d",time())}} max={{date("Y-m-d",time()+2592000)}} required name="date" id="date"
                       value='{{ Request::old('date') }}'>
            </div>
                </div>
                <div class="col-sm-2">
            <button class="btn btn-success btn-block" type="submit">{{trans('admin.book')}}</button>
                </div>
            <input type="hidden" name="id" value= {{ $bookable->id }} >
            <input type="hidden" name="_token" value= {{ Session::token() }} >
            </div>
        </form>
<p class="lead text-center">NOT ALLOWED DAYS</p>
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <table class="table table-bordered table-condensed table-striped table-responsive">
                    <thead>
                    <tr>
                        <th>{{trans('admin.day')}}</th>
                        <th>{{trans('admin.date')}}</th>
                    </tr>
                    </thead>
                    <?php
                    $time = time();
                    for ($i = 0; $i < 30; $i++) {
                        $time += 86400;
                        $date = getdate($time);
                        if (!$allowed[$i]) {
                            echo "<tr class='danger'>";
                            $d = $date['mday'];
                            $m = $date['mon'];
                            $y = $date['year'];
                            $weekday = $date['weekday'];
                            $temp = $y * 10000 + $m * 100 + $d;
                            echo "<td>" . $weekday . "</td>";
                            echo "<td>" . $d . "  /  " . $m . "  /  " . $y . "." . "</td>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

@endsection
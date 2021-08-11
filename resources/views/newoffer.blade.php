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
            <hr/>
        </div>
    </div>

    <div class="container-fluid">
        <br/>
        <p class="lead text-center">{{trans('admin.make_offer')}}</p>
        <form action="{{route('makeoffer')}}" method="post">
            <div class="form-group">
                <label for="target">{{trans('admin.target')}} *</label>
                <select name="target" id="target" class="form-control">
                    <option value="1">{{trans('admin.loyals')}}</option>
                    <option value="2">{{trans('admin.clients')}}</option>
                    <option value="3">{{trans('admin.people')}}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="number">{{trans('admin.if')}}</label>
                <input class="form-control" type="text" name="number" id="number"
                       value='{{ Request::old('number') }}'>
            </div>
            <div class="form-group">
                <label for="content">{{trans('admin.desc')}} *</label>
                <textarea class="form-control" rows="5" name="content" required
                          id="content">{{ Request::old('content') }}</textarea>
            </div>
            <div class="form-group">
                <label for="discount">{{trans('admin.discount')}} (%)</label>
                <input class="form-control" type="text" name="discount" id="discount"
                       value='{{ Request::old('discount') }}'>
            </div>
            <div class="form-group">
                <label for="start">{{trans('admin.start')}} *</label>
                <input class="form-control" type="date" name="start" id="start" required
                       value='{{ Request::old('start') }}'>
            </div>
            <div class="form-group">
                <label for="end">{{trans('admin.finish')}} *</label>
                <input class="form-control" type="date" name="end" id="end" required
                       value='{{ Request::old('end') }}'>
            </div>
            <button class="btn btn-success center-block mybutton" type="submit">{{trans('admin.save')}}</button>
            <input type="hidden" name="id" value= {{ $bookable->id }} >
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>
    <hr/>
    <div class="container-fluid">
        <br/>
        <p class="lead text-center">{{trans('admin.offer_list')}}</p>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>{{trans('admin.content')}}</th>
                <th>{{trans('admin.target')}}</th>
                <th>{{trans('admin.discount')}}(%)</th>
                <th>{{trans('admin.start')}}</th>
                <th>{{trans('admin.finish')}}</th>
                <th>{{trans('admin.creation_date')}}</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            @foreach($bookable->offers()->orderBy('created_at','desc')->get() as $offer)
                <tr>
                    <td>{{$offer->content}}</td>
                    <td>
                        @if($offer->target==1)
                            {{trans('admin.loyals')}} ({{$offer->number}})
                        @elseif($offer->target==2)
                            {{trans('admin.clients')}}
                        @else
                            {{trans('admin.people')}}
                        @endif
                    </td>
                    <td>{{$offer->discount}}</td>
                    <?php
                    $dd = $offer->start;
                    $d = $dd % 100;
                    $m = ($dd % 10000 - $d) / 100;
                    $y = ($dd - $m * 100 - $d) / 10000;
                    $temp = $y * 10000 + $m * 100 + $d;
                    echo "<td>" . $d . "  /  " . $m . "  /  " . $y . "." . "</td>";
                    $dd = $offer->end;
                    $d = $dd % 100;
                    $m = ($dd % 10000 - $d) / 100;
                    $y = ($dd - $m * 100 - $d) / 10000;
                    $temp = $y * 10000 + $m * 100 + $d;
                    echo "<td>" . $d . "  /  " . $m . "  /  " . $y . "." . "</td>";
                            ?>
                    <td>{{$offer->created_at}}</td>
                    <td><a href={{route('activateoffer',['id'=>$offer->id])}}>
                            @if($offer->available)
                                Disactivate
                            @else
                                Activate
                            @endif
                        </a></td>
                    <td><a href="{{route('editoffer',['id'=>$offer->id])}}">Edit</a> </td>
                    <td><a href="{{route('deleteoffer',['id'=>$offer->id])}}"><i class="fa fa-trash fa-2x"></i></a> </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
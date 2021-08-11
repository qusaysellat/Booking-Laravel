@extends('layouts.master')
@section('title')
    {{$offer->bookable->name}}
@endsection
@section('content')
    <div class="container-fluid">
        <br/>
        <p class="lead text-center">{{trans('admin.make_offer')}}</p>
        <form action="{{route('posteditoffer')}}" method="post">
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
                       value='{{ $offer->number }}'>
            </div>
            <div class="form-group">
                <label for="content">{{trans('admin.desc')}} *</label>
                <textarea class="form-control" rows="5" name="content" required
                          id="content">{{ $offer->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="discount">{{trans('admin.discount')}} (%)</label>
                <input class="form-control" type="text" name="discount" id="discount"
                       value='{{$offer->discount }}'>
            </div>
            <div class="form-group">
                <label for="start">{{trans('admin.start')}} * (mm/dd/yyyy)</label>
                <input class="form-control" type="text" name="start" id="start" required
                       value="<?php
                    $dd = $offer->start;
                    $d = $dd % 100;
                    $m = ($dd % 10000 - $d) / 100;
                    $y = ($dd - $m * 100 - $d) / 10000;
                    $temp = $y * 10000 + $m * 100 + $d;
                    echo  $m . "/" . $d . "/" . $y;
                    ?>"
                >
            </div>
            <div class="form-group">
                <label for="end">{{trans('admin.finish')}} * (mm/dd/yyyy)</label>
                <input class="form-control" type="text" name="end" id="end" required
                       value="<?php
                       $dd = $offer->end;
                       $d = $dd % 100;
                       $m = ($dd % 10000 - $d) / 100;
                       $y = ($dd - $m * 100 - $d) / 10000;
                       $temp = $y * 10000 + $m * 100 + $d;
                       echo  $m . "/" . $d . "/" . $y;
                       ?>"
                >
            </div>
            <button class="btn btn-success center-block mybutton" type="submit">{{trans('admin.save')}}</button>
            <input type="hidden" name="id" value= {{ $offer->id }} >
            <input type="hidden" name="_token" value= {{ Session::token() }} >
        </form>
    </div>
@endsection
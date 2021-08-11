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
                    @if(!$guest && Auth::user()->category->id==1)
                        <div class="col-md-2">
                            <a href="{{route('seebookable',['id'=>$bookable->id])}}">
                                <button class="btn btn-info">{{trans('admin.book')}}</button>
                            </a>
                        </div>
                    @endif
                    @if($guest)
                        <div class="col-md-2">
                            {{trans('admin.signin_to_book')}}
                            <a href="{{route('login')}}">
                                <button class="btn btn-info">{{trans('admin.signin')}}</button>
                            </a>
                        </div>
                    @endif
                </div>
                @if($guest || Auth::user()->category->id==1)
                    @foreach($bookable->offers()->where('available', 1)->where('end', '>=', $temp)->get() as $offer)
                        <div class="offer">
                            @if($offer->target==1)
                                <p class="label label-danger"> {{trans('admin.loyals')}} ({{$offer->number}})
                                    &ensp;<br/> &ensp;{{trans('admin.youshould')}}  </p>
                            @elseif($offer->target==2)
                                <p class="label label-warning">{{trans('admin.clients')}}&ensp; <br/>
                                    &ensp;{{trans('admin.youshould')}}</p>
                            @else
                                <p class="label label-info"> {{trans('admin.people')}}</p>
                            @endif
                            <br/>
                            <?php
                            $dd = $offer->start;
                            $d = $dd % 100;
                            $m = ($dd % 10000 - $d) / 100;
                            $y = ($dd - $m * 100 - $d) / 10000;
                            $temp = $y * 10000 + $m * 100 + $d;
                            echo "<p class='label label-success'>" . $d . "  /  " . $m . "  /  " . $y . "</p>";
                            echo " to ";
                            $dd = $offer->end;
                            $d = $dd % 100;
                            $m = ($dd % 10000 - $d) / 100;
                            $y = ($dd - $m * 100 - $d) / 10000;
                            $temp = $y * 10000 + $m * 100 + $d;
                            echo "<p class='label label-success'>" . $d . "  /  " . $m . "  /  " . $y . "</p>";
                            ?>
                            <br/>
                            {{$offer->content}}
                        </div>
                    @endforeach
                @endif
            </div>

        @endforeach
        </div>
    </div>
@endsection
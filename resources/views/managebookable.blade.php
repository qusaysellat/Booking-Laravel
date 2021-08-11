@extends('layouts.master')
@section('title')
    {{$bookable->name}}
@endsection
@section('content')
    <div class="container-fluid">
        <p class="h1">{{trans('admin.manage_booking')}}</p>
        <p class="lead"><a href="{{route('getuser',['username'=>$bookable->user->username])}}">{{trans('admin.return')}}</a> </p>
        <hr/>
        <p class="h1">{{trans('admin.these_are')}}</p><br/>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>{{trans('admin.date')}}</th>
                <th>{{trans('admin.person')}}</th>
                <th>{{trans('admin.status')}}</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <?php
            for ($i = 0; $i < $num; $i++) {
                echo "<tr>";
                $dd = $day[$i];
                $d = $dd % 100;
                $m = ($dd % 10000 - $d) / 100;
                $y = ($dd - $m * 100 - $d) / 10000;
                $temp = $y * 10000 + $m * 100 + $d;
                echo "<td>" . $d . "  /  " . $m . "  /  " . $y . "." . "</td>";
                echo "<td><a href='".route('getuser',['username'=>$users[$i]])."'> " . $users[$i] . "</a></td>";
                if ($status[$i] == 0) {
                    echo "<td class='warning'> ".trans('admin.pen')." </td>";
                    echo "<td><a href='" . route('acceptbook', ['id' => $bookable->id, 'username' => $users[$i], 'date' => $temp]) . "'>Accept</a></td>";
                    echo "<td><a href='" . route('rejectbook', ['id' => $bookable->id, 'username' => $users[$i], 'date' => $temp]) . "'>Reject</a></td></tr>";
                } else if ($status[$i] == 1) {
                    echo "<td class='info'> ".trans('admin.acc')." </td>";
                    echo "<td> Accept </td>";
                    echo "<td> Reject </td>";
                } else {
                    echo "<td class='danger'> ".trans('admin.rej')." </td>";
                    echo "<td>  ".trans('admin.accept')."  </td>";
                    echo "<td>  ".trans('admin.reject')."  </td>";
                }

            }
            ?>
        </table>
    </div>

@endsection
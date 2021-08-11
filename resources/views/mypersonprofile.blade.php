@extends('layouts.user')
@section('morecontent')
    <div class="container-fluid">
    <p class="lead text-center">{{trans('admin.booking_history')}}</p>
    <table class="table table-bordered table-condensed table-striped table-responsive">
        <thead>
        <tr>
            <th>{{trans('admin.day')}}</th>
            <th>{{trans('admin.item')}}</th>
            <th>{{trans('admin.brand')}}</th>
            <th>{{trans('admin.status')}}</th>
            <th>{{trans('admin.creation_date')}}</th>
        </tr>
        </thead>
        <?php
        foreach ($user->booked as $book) {
            echo "<tr>";
            $dd = $book->pivot->day;
            $d = $dd % 100;
            $m = ($dd % 10000 - $d) / 100;
            $y = ($dd - $m * 100 - $d) / 10000;
            $temp = $y * 10000 + $m * 100 + $d;
            echo "<td>" . $d . "  /  " . $m . "  /  " . $y . "." . "</td>";
            echo "<td>" . $book->name . "</td>";
            echo "<td>" . $book->user->username . "</td>";
            $status = $book->pivot->status;
            if ($status == 0) {
                echo "<td class='warning'> ".trans('admin.pen')." </td>";
            } else if ($status == 1) {
                echo "<td class='info'> ".trans('admin.acc')." </td>";
            } else {
                echo "<td class='danger'> ".trans('admin.rej')." </td>";
            }
            echo "<td>" . $book->pivot->created_at . "</td></tr>";
        }
        ?>
    </table>
    </div>
@endsection
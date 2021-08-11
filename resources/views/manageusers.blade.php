@extends('layouts.adminlayout')
@section('title')
    Manage Users
@endsection
@section('content')
    <div class="container-fluid">
        <h1>Manage Users</h1>
        <p class="lead"><a href="{{route('adminpanel')}}">return</a> to main admin panel</p>
        <hr/>
        <p class="lead text-center">List Of Should-Pay Users</p>
        <table class="table table-bordered table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>Username</th>
                <th>Status</th>
                <th>Expiry Date</th>
                <th>Action</th>
            </tr>
            </thead>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->username}}</td>

                    @if($user->status==0)
                        <td class="danger">
                            NO_PAY_RESTRICTED
                        </td>
                    @else
                        <td class="warning">
                            HAS_TO_PAY
                        </td>
                    @endif

                    <td>
                        @if($user->expiry>0)
                            <?php
                            $dd = $user->expiry;
                            $d = $dd % 100;
                            $m = ($dd % 10000 - $d) / 100;
                            $y = ($dd - $m * 100 - $d) / 10000;
                            $temp = $y * 10000 + $m * 100 + $d;
                            echo $d . "  /  " . $m . "  /  " . $y;
                            ?>
                        @else
                            NEW_USER
                        @endif
                    </td>
                    <td><a href={{route('activateuser',['username'=>$user->username])}}> Activate</a></td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection
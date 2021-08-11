@extends('layouts.user')
@section('morecontent')
    <?php
    $tempuser = Auth::user();
    ?>
    @if(isset($tempuser) && $tempuser->category->id<>1)
        <?php
        $value = 0;
        $temp2="NOT LOYAL";
        $temp1 = DB::table('loyalty')->where('user2_id', $tempuser->id)->where('user1_id', $user->id)->first();
        if (isset($temp1)) {
            $value = $temp1->value;
        $temp2 = DB::table('loyalty')->where('user2_id', $tempuser->id)->where('value', '>', $value)->orWhere('user2_id', $tempuser->id)->where('value', $value)->where('updated_at', '>', $temp1->updated_at)->count();
        $temp2++;
        }
        ?>
        <p class="lead">
            {{
                trans('admin.loyalty').' : '.$value
            }}
        </p>
        <p class="lead">
            {{
            trans('admin.loyaltyOrder').' : '.$temp2
            }}
        </p>
    @endif
@endsection
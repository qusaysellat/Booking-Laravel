<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Category;
use App\City;
use App\Bookable;
use App\Offer;
use App\Notification;
use App\Advertisement;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SchedulingController extends Controller
{
    public function sendOffers()
    {
        $temp = $this->makeintegerdate();
        $offers = Offer::where('available', 1)->where('end', '>=', $temp)->get();
        foreach ($offers as $offer) {
            if ($offer->bookable->user->status == 0) continue;
            $content = "Hello, " . $offer->bookable->user->username . " Has An Offer On " . $offer->bookable->name . " : " . $offer->content . " Booking.com Thought You May Be Interested.";
            if ($offer->target <> 3) {
                $limit = ($offer->type <> 2) ? ($offer->number <> 0) ? $offer->number : 1000 : 10000000;
                $people = DB::table('loyalty')->where('user2_id', $offer->bookable->user->id)->orderBy('value', 'desc')->orderBy('updated_at','desc')->limit($limit)->get();
                foreach ($people as $person) {
                    $this->createnotification($content, 1, $person->user1_id, $person->user2_id);
                }
            } else {
                $users = User::select('id')->where('category_id', 1)->get();
                foreach ($users as $user) {
                    $this->createnotification($content, 1, $user->id, $offer->bookable->user->id);
                }
            }
        }
    }

    public function warnUsers()
    {
        $time = time() + 2592000;
        $date = getdate($time);
        $d = $date['mday'];
        $m = $date['mon'];
        $y = $date['year'];
        $temp2 = $y * 10000 + $m * 100 + $d;
        $temp1 = $this->makeintegerdate();

        $users = User::select('id', 'expiry')->where('category_id', '<>', 1)->where('expiry', '<', $temp2)->where('status', 1)->get();
        foreach ($users as $user) {
            if ($user->expiry >= $temp1) {
                $notify = "You Have To Pay";
                $this->createnotification($notify, 2, $user->id, null);
            } else {
                $user2 = User::find($user->id);
                $user2->status = 0;
                $user2->save();
            }
        }

    }

    public function calculateRoulette(){
        $ads=Advertisement::orderBy('id','desc')->get();
        $sum=0;
        foreach ($ads as $ad){
            if($ad->available){
                 $sum+=$ad->importance;
                 $ad->roulette=$sum;
                 $ad->save();
            }
        }
    }

    public function cron(){
        $this->sendOffers();
        $this->warnUsers();
        $this->calculateRoulette();
    }

    public function createnotification($content, $type, $user_id, $other_user_id = null)
    {
        $user = User::find($user_id);
        $notification = new Notification();
        $notification->content = $content;
        $notification->type = $type;
        $notification->other_user_id = $other_user_id;

        $notification->user()->associate($user);

        $notification->save();
    }

    public function makeintegerdate()
    {
        $time = time();
        $date = getdate($time);
        $d = $date['mday'];
        $m = $date['mon'];
        $y = $date['year'];
        $temp = $y * 10000 + $m * 100 + $d;
        return $temp;
    }

}

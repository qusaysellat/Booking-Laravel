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

class ProfileController extends Controller
{
    public function getuser($username)
    {
        $advs = $this->getAds();
        if (Auth::user()) $guest = false;
        else $guest = true;
        if (User::where('username', $username)->where('status', 1)->count() == 0) return redirect()->route('dashboard');
        $user = User::where('username', $username)->first();
        /*
        $offers=array();
        if(!$guest&&Auth::user()->category->id==1&&$user->category->id!==1){
            $offers=$this->getUserOffers(Auth::user()->id,$user->id);
        }*/
        $temp=$this->makeintegerdate();
        if (!$guest && Auth::user()->id == $user->id) {
            if ($user->category->id == 1)
                return view('mypersonprofile', ['user' => $user, 'guest' => $guest, 'advs' => $advs]);
            else
                return view('mynonpersonprofile', ['user' => $user, 'guest' => $guest, 'advs' => $advs]);
        } else {
            if ($user->category->id == 1)
                return view('anotherpersonprofile', ['user' => $user, 'guest' => $guest, 'advs' => $advs]);
            else
                return view('anothernonpersonprofile', ['user' => $user, 'guest' => $guest, 'advs' => $advs,'temp'=>$temp]);
        }
    }

    public function newbookable(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'number' => 'required|numeric',
            'price' => 'required|numeric'
        ]);
        $bookable = new Bookable();
        $bookable->name = $request['name'];
        $bookable->number = $request['number'];
        $bookable->price = $request['price'];
        $description = $request['description'];
        if (strlen($description)) $bookable->description = $description;

        $bookable->user()->associate(Auth::user());

        $bookable->save();

        $message = "Bookable Item Added Successfully";
        session(['message' => $message]);

        return redirect()->route('getuser', ['username' => Auth::user()->username]);
    }

    public function allowed($id, $date)
    {
        if (Bookable::where('id', $id)->count() == 0) return 0;
        if ($date > time() + 86400 * 30) return 0;
        $bookable = Bookable::find($id);
        $user = Auth::user();
        $number = $bookable->number;
        $booked = DB::table('booked')->where('bookable_id', $id)->where('day', $date)->count();
        $bookedbefore = DB::table('booked')->where('bookable_id', $id)->where('day', $date)->where('user_id', $user->id)->count();
        if ($number - $booked > 0 && $bookedbefore == 0)
            return 1;
        else
            return 0;
    }

    public function allowed2($id, $date)
    {
        if (Bookable::where('id', $id)->count() == 0) return 0;
        if ($date > time() + 86400 * 30) return 0;
        $bookable = Bookable::find($id);
        $number = $bookable->number;
        $booked = DB::table('booked')->where('bookable_id', $id)->where('day', $date)->count();
        if ($number - $booked > 0)
            return 1;
        else
            return 0;
    }

    public function seebookable($id)
    {
        $advs = $this->getAds();
        if (Bookable::where('id', $id)->count() == 0 || Auth::user()->category->id <> 1)
            return redirect()->back();
        $bookable = Bookable::find($id);
        $allowed = array();
        $time = time();
        for ($i = 0; $i < 30; $i++) {
            $time += 86400;
            $date = getdate($time);
            $d = $date['mday'];
            $m = $date['mon'];
            $y = $date['year'];
            $temp = $y * 10000 + $m * 100 + $d;
            $allowed[$i] = $this->allowed($id, $temp);
        }
        return view('seebookable', ['bookable' => $bookable, 'allowed' => $allowed, 'advs' => $advs]);
    }

    public function deletebookable($id){
        if (Bookable::where('id', $id)->count() == 0 )
            return redirect()->route('getuser',['username'=>Auth::user()->username]);
        $bookable = Bookable::find($id);
        if($bookable->user->id<>Auth::user()->id)
            return redirect()->back();
        DB::table('bookables')->where('id',$id)->delete();
        DB::table('booked')->where('bookable_id',$id)->delete();
        DB::table('offers')->where('bookable_id',$id)->delete();
        $message = "Bookable Item Was Deleted Successfully";
        session(['message' => $message]);
        return redirect()->route('getuser',['username'=>Auth::user()->username]);

    }

    public function book(Request $request)
    {
        $id = $request['id'];
        $date = $this->makeintegerdate2($request['date']);
        $user = Auth::user();
        if ($user->category->id <> 1)
            return redirect()->back();
        if ($this->allowed($id, $date) == 1) {
            $bookable = Bookable::find($id);
            $bookable->people()->attach($user->id, ['day' => $date]);
        } else {
            $message = "You Can't Book At This Day , See Table Below!";
            session(['warning' => $message]);

            return redirect()->route('seebookable', ['id' => $id]);
        }

        $message = "Your Booking Request Was Saved , We Will Send You Response As Soon As Possible ";
        session(['message' => $message]);

        return redirect()->route('seebookable', ['id' => $id]);
    }

    public function managebookable($id)
    {
        $advs = $this->getAds();
        if (Bookable::where('id', $id)->count() == 0)
            return redirect()->back();
        $bookable = Bookable::find($id);
        if (Auth::user()->id <> $bookable->user->id)
            return redirect()->back();

        $temp = $this->makeintegerdate();

        $reservations = DB::table('booked')->where('bookable_id', $id)->where('day', '>=', $temp)->orderBy('day')->orderBy('created_at')->get();
        $i = 0;
        $users = array();
        $status = array();
        $day = array();
        foreach ($reservations as $reservation) {
            $user_id = $reservation->user_id;
            $users[$i] = User::find($user_id)->username;
            $status[$i] = $reservation->status;
            $day[$i] = $reservation->day;
            $i++;
        }
        return view('managebookable', ['bookable' => $bookable, 'users' => $users, 'status' => $status, 'day' => $day, 'num' => $i, 'advs' => $advs]);
    }

    public function editbookable($id)
    {
        $advs = $this->getAds();
        $bookable = Bookable::find($id);
        if (isset($bookable) && $bookable->user->id == Auth::user()->id)
            return view('editbookable', ['bookable' => $bookable, 'advs' => $advs]);
        return redirect()->back();
    }

    public function posteditbookable(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'number' => 'required|numeric',
            'price' => 'required|numeric',
            'id' => 'required|numeric'
        ]);
        $bookable = Bookable::find($request['id']);
        if (isset($bookable) && $bookable->user->id == Auth::user()->id) {

            $bookable->name = $request['name'];
            $bookable->number = $request['number'];
            $bookable->price = $request['price'];
            $description = $request['description'];
            $bookable->description = $description;

            $bookable->save();

            $message = "Bookable Item Edited Successfully";
            session(['message' => $message]);
            return redirect()->route('managebookable', ['id' => $bookable->id]);
        }

        return redirect()->back();
    }

    public function acceptbook($id, $username, $date)
    {
        if (User::where('username', $username)->count() == 0) return redirect()->back();

        $user = User::where('username', $username)->first();
        $me = Auth::user();
        if ($this->allowed2($id, $date) == 1) {
            $bookable = Bookable::find($id);
            if ($me->id <> $bookable->user->id) return redirect()->back();
            if (DB::table('booked')->where('bookable_id', $id)->where('user_id', $user->id)->where('day', $date)->where('status', 0)->count() <> 1) return redirect()->back();
            DB::table('booked')->where('bookable_id', $id)->where('user_id', $user->id)->where('day', $date)->update(['status' => 1]);
            if (DB::table('loyalty')->where('user2_id', $me->id)->where('user1_id', $user->id)->count() == 0)
                $me->people()->attach([$user->id => ['value' => 1]]);
            else {
                $temp = DB::table('loyalty')->where('user2_id', $me->id)->where('user1_id', $user->id)->first();
                $me->people()->syncWithoutDetaching([$user->id => ['value' => $temp->value + 1]]);
            }
            $bookable->popularity = $bookable->popularity + 1;
            $bookable->save();
            $me->popularity = $me->popularity + 1;
            $me->save();

            $message = "Accepted Successfully ";
            session(['message' => $message]);

            $d = $date % 100;
            $m = ($date % 10000 - $d) / 100;
            $y = ($date - $m * 100 - $d) / 10000;
            $content = "Hello " . $username . ", Your Reservation At " . $bookable->name . ", " . $me->username . " On " . $d . " / " . $m . " / " . $y . " Has Been Confirmed, Thank You For Using Our Website";
            $this->createnotification($content, 0, $user->id, $me->id);

            return redirect()->route('managebookable', ['id' => $id]);
        } else {

            $message = "There Is No Available Places ";
            session(['message' => $message]);

            return redirect()->route('managebookable', ['id' => $id]);
        }
    }

    public function rejectbook($id, $username, $date)
    {
        if (User::where('username', $username)->count() == 0 || Bookable::where('id', $id)->count() == 0) return redirect()->back();
        $bookable = Bookable::find($id);
        if (Auth::user()->id <> $bookable->user->id) return redirect()->back();
        $user = User::where('username', $username)->first();
        DB::table('booked')->where('bookable_id', $id)->where('user_id', $user->id)->where('day', $date)->update(['status' => -1]);

        $message = "Rejected Successfully ";
        session(['message' => $message]);

        $d = $date % 100;
        $m = ($date % 10000 - $d) / 100;
        $y = ($date - $m * 100 - $d) / 10000;
        $content = "Hello " . $username . ", We Are Afraid That Your Reservation At " . $bookable->name . ", " . $bookable->user->username . " On " . $d . " / " . $m . " / " . $y . " Has Been Rejected, Thank You For Understanding";
        $this->createnotification($content, 0, $user->id, $bookable->user->id);

        return redirect()->route('managebookable', ['id' => $id]);
    }

    public function newoffer($id)
    {
        $advs = $this->getAds();
        if (Bookable::where('id', $id)->count() == 0)
            return redirect()->back();
        $bookable = Bookable::find($id);
        if (Auth::user()->id <> $bookable->user->id)
            return redirect()->back();
        return view('newoffer', ['bookable' => $bookable, 'advs' => $advs]);
    }

    public function makeoffer(Request $request)
    {
        $this->validate($request, [
            'target' => 'required',
            'content' => 'required|max:2000',
            'number' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'id' => 'required'
        ]);
        $id = $request['id'];
        if (Bookable::where('id', $id)->count() == 0)
            return redirect()->back();
        $bookable = Bookable::find($id);
        if (Auth::user()->id <> $bookable->user->id)
            return redirect()->back();

        $content = $request['content'];
        $target = intval($request['target']);
        $number = intval($request['number']);
        if (strlen($number) < 1)
            $number = 0;
        $discount = $request['discount'];
        if (strlen($discount) < 1)
            $discount = 0;
        $offer = new Offer();
        $offer->target = $target;
        $offer->content = $content;
        $offer->discount = $discount;
        $offer->number = $number;

        $temp1 = $this->makeintegerdate2($request['start']);
        $temp2 = $this->makeintegerdate2($request['end']);

        $offer->start = $temp1;
        $offer->end = $temp2;

        $offer->bookable()->associate($bookable);

        $offer->save();

        $message = "Offer Item Added Successfully , In Order The Offer To Be Available , You Should Activate It From The List Below";
        session(['message' => $message]);

        return redirect()->route('newoffer', ['id' => $id]);
    }

    public function deleteoffer($id){
        $offer = Offer::find($id);
        if (isset($offer) && $offer->bookable->user->id == Auth::user()->id){
            DB::table('offers')->where('id',$id)->delete();
            $message = "Offer Was Deleted Successfully";
            session(['message' => $message]);
        }
        return redirect()->route('getuser',['username'=>Auth::user()->username]);
    }


    public function editoffer($id)
    {
        $advs = $this->getAds();
        $offer = Offer::find($id);
        if (isset($offer) && $offer->bookable->user->id == Auth::user()->id)
            return view('editoffer', ['offer' => $offer, 'advs' => $advs]);
        return redirect()->back();
    }

    public function posteditoffer(Request $request)
    {
        $this->validate($request, [
            'target' => 'required',
            'content' => 'required|max:2000',
            'number' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'id' => 'required|numeric'
        ]);

        $offer = Offer::find($request['id']);
        if (isset($offer) && $offer->bookable->user->id == Auth::user()->id) {

            $content = $request['content'];
            $target = intval($request['target']);
            $number = intval($request['number']);
            if (strlen($number) < 1)
                $number = 0;
            $discount = $request['discount'];
            if (strlen($discount) < 1)
                $discount = 0;
            $offer->target = $target;
            $offer->content = $content;
            $offer->discount = $discount;
            $offer->number = $number;

            $temp1 = $this->makeintegerdate2($request['start']);
            $temp2 = $this->makeintegerdate2($request['end']);

            $offer->start = $temp1;
            $offer->end = $temp2;

            $offer->save();

            $message = "Offer Item Edited Successfully";
            session(['message' => $message]);

            return redirect()->route('newoffer', ['id' => $offer->bookable->id]);

        }
        return redirect()->back();
    }

    public function activateoffer($id)
    {
        $me = Auth::user();
        if (Offer::where('id', $id)->count() == 0)
            return redirect()->back();
        $offer = Offer::find($id);
        if ($me->id <> $offer->bookable->user->id)
            return redirect()->back();

        $offer->available = !($offer->available);
        $offer->save();

        if ($offer->available)
            $message = "Activated Successfully";
        else
            $message = "Disactivated Successfully";
        session(['message' => $message]);

        return redirect()->route('newoffer', ['id' => $offer->bookable->id]);

    }

    public function createnotification($content, $type, $user_id, $other_user_id)
    {
        $user = User::find($user_id);
        $notification = new Notification();
        $notification->content = $content;
        $notification->type = $type;
        $notification->other_user_id = $other_user_id;

        $notification->user()->associate($user);

        $notification->save();
    }

    public function seenotifications()
    {
        $advs = $this->getAds();
        $user = Auth::user();
        if (!isset($user)) return redirect()->back();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();
        $users = array();
        foreach ($notifications as $notification) {
            if (isset($notification->other_user_id))
                $users[$notification->id] = User::find($notification->other_user_id)->username;
            else
                $users[$notification->id] = 0;
        }
        $user->notifications()->where('read', 0)->update(['read' => 1]);
        return view('seenotifications', ['notifications' => $notifications, 'users' => $users, 'advs' => $advs]);
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

    public function makeintegerdate2($date)
    {
        $time = strtotime($date);
        $date = getdate($time);
        $d = $date['mday'];
        $m = $date['mon'];
        $y = $date['year'];
        $temp = $y * 10000 + $m * 100 + $d;
        return $temp;
    }

    public function getAds()
    {
        $advs = array();
        $cnt = Advertisement::where('available', 1)->count();
        if ($cnt > 0) {
            $max = Advertisement::where('available', 1)->first();
            $random = rand(1, $max->roulette);
            $advs[1] = Advertisement::where('roulette', '>=', $random)->orderBy('id', 'desc')->where('available', 1)->first();
            if ($cnt > 1) {
                $random = rand(1, $max->roulette);
                $advs[2] = Advertisement::where('roulette', '>=', $random)->orderBy('id', 'desc')->where('available', 1)->first();
                while($advs[2]->id==$advs[1]->id){
                    $random = rand(1, $max->roulette);
                    $advs[2] = Advertisement::where('roulette', '>=', $random)->orderBy('id', 'desc')->where('available', 1)->first();
                }
            }
        }
        return $advs;
    }

    public function getUserOffers($user_id,$brand_id){/*
        $temp = $this->makeintegerdate();
        $offers = Offer::where('available', 1)->where('start', '<=', $temp)->where('end', '>=', $temp)->where('user_id',$brand_id)->get();
        $loyalty=DB::table('loyalty')->where('user1_id',$user_id)->where('user2_id',$brand_id)->first();
        if(isset($loyalty)){
            $temp=$loyalty->value;
            $higher=DB::table('loyalty')->where('value','>',$user_id)->where('user2_id',$brand_id)->first();
        }*/
    }

}

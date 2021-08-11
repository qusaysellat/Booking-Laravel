<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Category;
use App\City;
use App\Image;
use App\Bookable;
use App\VerifyUser;
use App\Advertisement;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\VerifyMail;
use Mail;

class UserController extends Controller
{
    public function configureddashboard($category_id, $city_id)
    {
        $advs = $this->getAds();
            $categories = Category::all();
            $cities = City::all();
            $temp1 = trans('admin.all_categories');
            $temp2 = trans('admin.all_cities');
            if ($category_id == 0 && $city_id == 0) {
                $users = User::where('status', 1)->where('category_id','<>',1)->orderBy('popularity', 'desc')->get();
            } else if ($category_id == 0) {
                $city = City::find($city_id);
                $temp2 = ' ' . $city->name . ' '.trans('admin.city');
                $users = User::where('status', 1)->where('category_id','<>',1)->where('city_id', $city_id)->orderBy('popularity', 'desc')->get();
            } else if ($city_id == 0) {
                $category = Category::find($category_id);
                $temp1 = ' ' . $category->name . ' '.trans('admin.category');
                $users = User::where('status', 1)->where('category_id','<>',1)->where('category_id', $category_id)->orderBy('popularity', 'desc')->get();
            } else {
                $category = Category::find($category_id);
                $temp1 = ' ' . $category->name . ' '.trans('admin.category');
                $city = City::find($city_id);
                $temp2 = ' ' . $city->name . ' '.trans('admin.city');
                $users = User::where('status', 1)->where('category_id','<>',1)->where('city_id', $city_id)->where('category_id', $category_id)->orderBy('popularity', 'desc')->get();
            }
            $explanation = trans('admin.clarify');
            return view('dashboard', ['city'=>$temp2,'category'=>$temp1,'categories' => $categories, 'cities' => $cities, 'users' => $users, 'category_id' => $category_id, 'city_id' => $city_id, 'explanation' => $explanation,'advs'=>$advs]);

    }

    public function dashboard()
    {
        return $this->configureddashboard(0, 0);
    }

    public function login(){
        $user=Auth::user();
        if(isset($user)) return redirect()->route('dashboard');
        return view('welcome');
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'status' => 1])) {
            if(Auth::user()->username=='Admin')return redirect()->route('adminpanel');
            return redirect()->route('dashboard');
        } else {
            $message = "Sorry, Failed Attempt To Sign In , Make Sure Email And Password Are Right And That You Are An Activated User ";
            session(['warning' => $message]);
            return redirect()->back();
        }
    }

    public function signout()
    {
        if (Auth::user()) {
            Auth::logout();
        }
        return redirect()->route('dashboard');
    }

    public function presignup()
    {
        if (Auth::user()) {
            return redirect()->route('dashboard');
        } else {
            $categories = Category::all();
            $cities = City::all();
            return view('signup', ['categories' => $categories, 'cities' => $cities]);
        }
    }

    public function postsignup(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'username' => 'required|min:1|max:150|unique:users',
            'city' => 'required',
            'type' => 'required',
            'description' => 'max:5000',
            'user_name' => 'max:0',
        ]);

        $catid = intval($request['type']);
        $cityid = intval($request['city']);

        if (Category::where('id', $catid)->count() == 0 || City::where('id', $cityid)->count() == 0) return redirect()->back();

        $user = new User();
        $user->email = $request['email'];
        $user->username = $request['username'];
        $user->password = bcrypt($request['password']);

        $address = $request['address'];
        $cemail = $request['cemail'];
        $phone1 = $request['phone1'];
        $phone2 = $request['phone2'];
        $website = $request['website'];
        $description = $request['description'];

        if (strlen($address)) $user->address = $address;
        if (strlen($cemail)) $user->contactemail = $cemail;
        if (strlen($phone1)) $user->phone1 = $phone1;
        if (strlen($phone2)) $user->phone2 = $phone2;
        if (strlen($website)) $user->website = $website;
        if (strlen($description)) $user->description = $description;

        $category = Category::find($catid);
        $city = City::find($cityid);
        $user->category()->associate($category);
        $user->city()->associate($city);

        if ($catid == 1)
            $user->paid = 1;
        else
            $user->paid = 0;

        /*if ($catid == 1)
            $user->status = 1;
        else
            $user->status = 0;*/

        $user->save();

        $verify = new VerifyUser();

        $verify->token = str_random(40);
        $verify->user()->associate($user);
        $verify->save();

        Mail::to($user->email)->send(new VerifyMail($user));

        $file = $request->file('image');

        if ($file) {
            $originalfilename = $request->file('image')->getClientOriginalName();
            $extension = pathinfo($originalfilename, PATHINFO_EXTENSION);
            if ($extension === 'jpg' || $extension === 'png' || $extension === 'jpeg') {
                $filename = $user->username . '.' . $extension;
                Storage::disk('public')->put($filename, File::get($file));
            }
        }

        $message = "Signed Up Successfully , Please Verify Your Email To Continue";
        session(['message' => $message]);

        return redirect()->route('dashboard');
    }

    public function profileimage($id)
    {
        $file = Storage::disk('public')->get('default.png');
        if (User::where('id', $id)->count() == 0) return Response($file, 200);
        $user = User::find($id);
        $jpgimage = $user->username . '.' . 'jpg';
        $jpegimage = $user->username . '.' . 'jpeg';
        $pngimage = $user->username . '.' . 'png';
        if (Storage::disk('public')->has($jpgimage))
            $file = Storage::disk('public')->get($jpgimage);
        else if (Storage::disk('public')->has($jpegimage))
            $file = Storage::disk('public')->get($jpegimage);
        else if (Storage::disk('public')->has($pngimage))
            $file = Storage::disk('public')->get($pngimage);
        return Response($file, 200);
    }

    public function registerationmail($token)
    {
        $verify = VerifyUser::where('token', $token)->first();
        if (isset($verify)) {
            $user = $verify->user;
            $catid = $user->category->id;
            if ($catid == 1)
                $user->status = 1;
            else
                $user->status = 0;
            $user->save();
            Auth::login($user);

            $message = "Verified Successfully , Welcome To Booking.com";
            session(['message' => $message]);

            return redirect()->route('dashboard');
        }
        $message = "Sorry, Failed Attempt To Activate An Account ";
        session(['warning' => $message]);
        return redirect()->route('dashboard');
    }

    public function search()
    {
        $token = $_GET['token'];
        if (strlen($token)) {
            $s = "%" . $token . "%";
            $results = User::where('username', 'like', $s)->where('status', 1)->orderBy('popularity', 'desc')->get();
            return view('searchresults', ['users' => $results, 'token' => $token]);
        } else {
            $message = "Please Type In Something To Search For!";
            session(['warning' => $message]);

            return redirect()->back();
        }
    }

    public function searchAjax(Request $request)
    {
        $token = $request['token'];
        if (strlen($token)) {
            $s = "%" . $token . "%";
            $results = User::select('username')->where('category_id','<>',1)->where('username', 'like', $s)->where('status', 1)->orderBy('popularity', 'desc')->limit(3)->get();
        } else $results = null;
        if (0 == count($results)) $results = null;
        $html = view('searchAjax')->with('results', $results)->render();

        return response()->json(['results' => $html], 200);
    }

    public function getAds(){
        $advs=array();
        $cnt=Advertisement::where('available',1)->count();
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

    public function addImage(Request $request){
        $this->validate($request, [
            'image' => 'required',
        ]);
        $user=Auth::user();
        $cnt=$user->images()->count();
        if($cnt>=5){
            $message="You Have Reached The Maximum Number Of Images";
            session(['warning' => $message]);
            return redirect()->route('getuser',['username'=>$user->username]);
        }

        $file = $request->file('image');

        if ($file) {
            $originalfilename = $request->file('image')->getClientOriginalName();
            $extension = pathinfo($originalfilename, PATHINFO_EXTENSION);
            if ($extension === 'jpg' || $extension === 'png' || $extension === 'jpeg') {
                $filename = $user->username . '_'.rand(100000,999999).'.'. $extension;
                $image=new Image();
                $image->name=$filename;
                $image->user()->associate($user);
                $image->save();
                Storage::disk('publicimages')->put($filename, File::get($file));
            }
            else{
                $message="You Should Upload An Image";
                session(['warning' => $message]);
                return redirect()->route('getuser',['username'=>$user->username]);
            }
        }

        $message = "Image Added Successfully";
        session(['message' => $message]);

        return redirect()->route('getuser',['username'=>$user->username]);
    }

    public function publicimage($id)
    {
        $image=Image::find($id);
        if(!isset($image)){
            return Response('not found',404);
        }
        $file = Storage::disk('publicimages')->get($image->name);
        return Response($file, 200);
    }

    public function deleteimage($id)
    {
        $image=Image::find($id);
        if(!isset($image)||Auth::user()->id<>$image->user->id){
            return redirect()->route('getuser',['username'=>Auth::user()->username]);
        }
        $file = Storage::disk('publicimages')->delete($image->name);
        DB::table('images')->where('id',$image->id)->delete();

        $message = "Image Deleted Successfully";
        session(['message' => $message]);

        return redirect()->route('getuser',['username'=>Auth::user()->username]);

    }


    public function lang($lang){
        if($lang<>'ar'&&$lang<>'en'&&$lang<>'fr')
            return redirect()->route('dashboard');
        Session::put('lang',$lang);
        return redirect()->route('dashboard');
    }


}

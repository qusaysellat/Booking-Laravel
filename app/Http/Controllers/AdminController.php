<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Category;
use App\City;
use App\Bookable;
use App\Advertisement;
use App\Contactus;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminpanel()
    {
        return view('adminpanel');
    }

    public function managecategories()
    {
        $categories = Category::all();
        return view('managecategories', ['categories' => $categories]);
    }

    public function managecities()
    {
        $cities = City::all();
        return view('managecities', ['cities' => $cities]);
    }

    public function newcategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'pay' => 'required|numeric',
        ]);
        $category = new Category();
        $category->name = $request['name'];
        $category->annualpayment = $request['pay'];
        $description = $request['description'];
        if (strlen($description)) $category->description = $description;

        $category->save();

        $message = "Category Added Successfully";
        session(['message' => $message]);

        return redirect()->route('managecategories');
    }

    public function editcategory($id)
    {
        $category = Category::find($id);
        if (isset($category)) {
            return view('editcategory', ['category' => $category]);
        } else return redirect()->route('managecategories');
    }

    public function posteditcategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'pay' => 'required|numeric',
            'id' => 'required|numeric'
        ]);
        $category = Category::find($request['id']);
        if (isset($category)) {
            $category->name = $request['name'];
            $category->annualpayment = $request['pay'];
            $description = $request['description'];
            $category->description = $description;

            $category->save();

            $message = "Category Edited Successfully";
            session(['message' => $message]);
        }

        return redirect()->route('managecategories');
    }

    public function newcity(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $city = new City();
        $city->name = $request['name'];

        $city->save();

        $message = "City Added Successfully";
        session(['message' => $message]);

        return redirect()->route('managecities');
    }

    public function editcity($id)
    {
        $city = City::find($id);
        if (isset($city)) {
            return view('editcity', ['city' => $city]);
        } else return redirect()->route('managecities');
    }

    public function posteditcity(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'id' => 'required|numeric'
        ]);

        $city = City::find($request['id']);
        if (isset($city)) {
            $city->name = $request['name'];

            $city->save();

            $message = "City Added Successfully";
            session(['message' => $message]);
        }

        return redirect()->route('managecities');
    }

    public function newadvertisement()
    {
        $ads = Advertisement::orderBy('created_at', 'desc')->get();
        return view('newadvertisement', ['ads' => $ads]);
    }

    public function makeadvertisement(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:1|max:150',
            'content' => 'max:200',
            'importance' => 'required|numeric|min:1|max:100',
        ]);

        $ad = new Advertisement();
        $ad->title = $request['title'];
        $ad->importance = intval($request['importance']);
        $content = $request['content'];
        if (strlen($content)) $ad->content = $content;

        $ad->save();

        $file = $request->file('image');

        if ($file) {
            $originalfilename = $request->file('image')->getClientOriginalName();
            $extension = pathinfo($originalfilename, PATHINFO_EXTENSION);
            if ($extension === 'jpg' || $extension === 'png' || $extension === 'jpeg') {
                $filename = $ad->id . '.' . $extension;
                Storage::disk('publicads')->put($filename, File::get($file));
                $ad->picname = 1;
            }
        }
        $ad->save();

        $message = "Advertisement Added Successfully , In Order The Advertisement To Be Available , You Should Activate It From The List Below";
        session(['message' => $message]);

        return redirect()->route('newadvertisement');
    }

    public function deleteadvertisement($id){
        $ad = Advertisement::find($id);
        if (isset($ad)) {
            DB::table('advertisements')->where('id', $id)->delete();
            $message = "Advertisement Deleted Successfully";
            session(['message' => $message]);
        }
        return redirect()->route('newadvertisement');
    }

    public function editadvertisement($id)
    {
        $ad = Advertisement::find($id);
        if (isset($ad))
            return view('editadvertisement', ['ad' => $ad]);
        return redirect()->route('newadvertisement');
    }

    public function posteditadvertisement(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:1|max:150',
            'content' => 'max:200',
            'importance' => 'required|numeric|min:1|max:100',
            'id' => 'required|numeric'
        ]);

        $ad = Advertisement::find($request['id']);
        if (isset($ad)) {
            $ad->title = $request['title'];
            $ad->importance = intval($request['importance']);
            $content = $request['content'];
            $ad->content = $content;
            $file = $request->file('image');

            if ($file) {
                $originalfilename = $request->file('image')->getClientOriginalName();
                $extension = pathinfo($originalfilename, PATHINFO_EXTENSION);
                if ($extension === 'jpg' || $extension === 'png' || $extension === 'jpeg') {
                    $filename = $ad->id . '.' . $extension;
                    Storage::disk('publicads')->put($filename, File::get($file));
                    $ad->picname = 1;
                }
            }
            else{
                $jpgimage = $ad->id . '.' . 'jpg';
                $jpegimage = $ad->id . '.' . 'jpeg';
                $pngimage = $ad->id . '.' . 'png';
                if (Storage::disk('publicads')->has($jpgimage))
                    $file = Storage::disk('publicads')->delete($jpgimage);
                else if (Storage::disk('publicads')->has($jpegimage))
                    $file = Storage::disk('publicads')->delete($jpegimage);
                else if (Storage::disk('publicads')->has($pngimage))
                    $file = Storage::disk('publicads')->delete($pngimage);
                $ad->picname=0;
            }
            $ad->save();

            $message = "Advertisement Edited Successfully";
            session(['message' => $message]);
        }
        return redirect()->route('newadvertisement');
    }

    public function activatead($id)
    {
        $ad = Advertisement::find($id);

        $ad->available = !($ad->available);
        $ad->save();

        if ($ad->available)
            $message = "Activated Successfully";
        else
            $message = "Disactivated Successfully";
        session(['message' => $message]);

        return redirect()->route('newadvertisement');
    }

    public function newcontactus()
    {
        if (Auth::user()) {
            $cu = Auth::user()->contactuses()->orderBy('created_at', 'desc')->get();
            return view('newcontactus', ['cu' => $cu]);
        } else {
            return redirect()->back();
        }
    }

    public function makecontactus(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required|min:1|max:150',
            'content' => 'required|max:2000',
        ]);

        $contactus = new Contactus();
        $contactus->subject = $request['subject'];
        $contactus->content = $request['content'];

        $contactus->user()->associate(Auth::user());
        $contactus->save();

        $message = "Thank You For Contacting Us";
        session(['message' => $message]);

        return redirect()->route('newcontactus');
    }

    public function readcontactus()
    {
        $cu = Contactus::orderBy('created_at', 'desc')->get();
        return view('readcontactus', ['cu' => $cu]);
    }

    public function replycontactus($id)
    {
        if (Contactus::where('id', $id)->count() > 0) {
            $cu = Contactus::find($id);
            if (strlen($cu->reply) == 0)
                return view('replycontactus', ['cu' => $cu]);
        }
        return redirect()->route('readcontactus');
    }

    public function editcontactus(Request $request)
    {
        $this->validate($request, [
            'reply' => 'required|min:1|max:5000',
            'id' => 'required',
        ]);

        $id = intval($request['id']);
        if (Contactus::where('id', $id)->count() > 0) {
            $cu = Contactus::find($id);
            if (strlen($cu->reply) == 0) {
                $cu->reply = $request['reply'];
                $cu->save();
            }
        }

        return redirect()->route('readcontactus');
    }

    public function manageusers()
    {
        $users = User::select('id', 'username', 'status' , 'paid' , 'expiry')->where('category_id', '>', 1)->where('paid', 0)->get();
        return view('manageusers', ['users' => $users]);
    }

    public function activateuser($username)
    {

        if (User::where('username', $username)->count() == 0) return redirect()->back();
        $user = User::where('username', $username)->first();
        if($user->status==0)
            $user->expiry=$this->makeintegerdate();
        else
            $user->expiry=$user->expiry+10000;
        $user->status = 1;
        $user->paid = 1;
        $user->save();

        session(['message' => "User " . $user->username . " Was Acitvated Successfully"]);

        return redirect()->route('manageusers');
    }

    public function makeintegerdate(){
        $time = time();
        $date = getdate($time);
        $d = $date['mday'];
        $m = $date['mon'];
        $y = $date['year']+1;
        $temp = $y * 10000 + $m * 100 + $d;
        return $temp;
    }

    public function adimage($id)
    {
        $file = Storage::disk('publicads')->get('default.png');
        if (Advertisement::where('id', $id)->count() == 0) return Response($file, 200);
        $ad = Advertisement::find($id);
        $jpgimage = $ad->id . '.' . 'jpg';
        $jpegimage = $ad->id . '.' . 'jpeg';
        $pngimage = $ad->id . '.' . 'png';
        if (Storage::disk('publicads')->has($jpgimage))
            $file = Storage::disk('publicads')->get($jpgimage);
        else if (Storage::disk('publicads')->has($jpegimage))
            $file = Storage::disk('publicads')->get($jpegimage);
        else if (Storage::disk('publicads')->has($pngimage))
            $file = Storage::disk('publicads')->get($pngimage);
        return Response($file, 200);
    }
}

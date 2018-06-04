<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Log;
use App\Http\Requests\ChangeName;
use App\Http\Requests\ChangeEmail;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show profile page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // profile.blade.php in /resources/admin
        return view('admin.profile');
    }

    public function changeName(ChangeName $req)
    {
        $name = $req->get('name');
        Log::info("change name of user:" . print_r(Auth::user(), true));
        Log::info("with name: " . $name);
        if(Auth::user()->name === $name) {
            Log::info("New name same as current name: " . $name);
            $req->session()->flash('status', 'Change name sucessful!');

            return redirect()->route('profile');
        }

        Auth::user()->name = $name;
        if(Auth::user()->save()) {
            Log::info("User name changed");
            $req->session()->flash('status', 'Change name sucessful!');

            return redirect()->route('profile');
        }

        Log::info("User name change failed!");

        return redirect()->route('profile')->with("errors", ['User name change failed!']);
    }

    /**
     * change email
     * 
     * @param Request $req
     */
    public function changeEmail(Request $req)
    {
        $email = $req->get('email');
        if(Auth::user()->email === $email) {
            $req->session()->flash('status', 'Change email sucessful!');

            return redirect()->route('profile');
        }

        $validated = $req->validate([
            'email' => 'required|email|unique:users'
        ]);
        if($validated->fails()) {
            return redirect()->route('profile')->with('errors', $validated->errors());
        }
    }

    /**
     * Change profile information
     * 
     * @param Request $req
     */
    public function changeProfile(Request $req)
    {
        $data = $req->all();

        if(isset($data['change-name'])) {
            if($this->changeName($data['name'])) {
                $req->session()->flash('status', 'Change name sucessful!');

                return redirect()->route('profile');
            } else {

            }
        }

    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Log;
use App\Http\Requests\ChangeName;
use App\Mail\ConfirmChangeMail;
use App\Repositories\Contracts\ChangeEmailRepositoryInterface as ChangeEmailRepository;
use App\Repositories\Contracts\UserRepositoryInterface as UserRepository;
use Validator;
use Mail;

class UserController extends Controller
{
    /**
     * change email repository
     * 
     * @property ChangeEmailRepositoryInterface $changeEmail
     */
    private $changeEmail;
    
    /**
    * user repository
    * 
    * @property UserRepository $user
    */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ChangeEmailRepository $changeEmail, UserRepository $user)
    {
        $this->changeEmail = $changeEmail;
        $this->user = $user;
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
        $user = Auth::user();
        if($user->email === $email) {
            Log::info("New email same as current email");
            $req->session()->flash('status', 'Change email successful!');

            return redirect()->route('profile');
        }

        $validator = Validator::make($req->all(), [
            'email' => 'required|email|unique:users'
        ]);

        if($validator->fails()) {
            return redirect()->route('profile')->with('errors', $validated->errors());
        }

        Log::info('Send email to confirm');
        $changeEmail = $this->changeEmail->add($user, $email);
        $link = url("/admin/confirm-change-email/" . $changeEmail->token);
        Mail::to($user)->send(new ConfirmChangeMail($user, $changeEmail, $link));

        $req->session()->flash('status', 'Please check your inbox to complete change email request');

        return redirect()->route('profile');
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

    public function confirmChangeEmail($token)
    {
        if ($this->user->changeMail($token)) {
            return view('admin.confirmed-email');
        } else {
            abort(404);
        }
    }
}

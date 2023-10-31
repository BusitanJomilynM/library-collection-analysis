<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();

        $messages = [
            "email.required" => "Email is required",
            "email.email" => "Email is not valid",
            "email.exists" => "Email doesn't exists",
            "password.required" => "Password is required",
            "password.exists" => "Password is invalid"
            
        ];

        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], $messages);

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->type == 'staff librarian') {
                return redirect()->route('staff.home');
            }else if (auth()->user()->type == 'department representative') {
                return redirect()->route('representative.home');
            }else if (auth()->user()->type == 'technician librarian') {
                return redirect()->route('technician.home');
            
            }else{
                return redirect()->route('login');
            }
        }
        else{
            return redirect()->route('login')
                ->with('error','Wrong password.');
        }
    }
}
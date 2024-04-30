<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
class UserController extends Controller
{

    public function __construct() 
    { 
        $this->middleware('preventBackHistory'); 
        $this->middleware('auth'); 
    
    } 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();
        Paginator::useBootstrap();
        if ($user->type === 'technician librarian') {
            if (request('search')) {
                $users = User::where('first_name', 'like', '%' . request('search') . '%')
                    ->orWhere('middle_name', 'like', '%' . request('search') . '%')
                    ->orWhere('last_name', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
                    ->orWhere('school_id', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            } else {
                $users = User::paginate(10);
            }
        } else {
            return redirect()->back();
        }
    
        $techcount = User::where('type', 'like', '0')->count();
        $userId = Auth::user()->id;
    
        return response()->view('users_layout.users_list', ['users' => $users, 'techcount' => $techcount, 'userId' => $userId]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('users_layout.users_list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'school_id' => 'required|integer|unique:users',
            'email' => 'email|unique:users',
            'contact_number' => 'required|unique:users',
            'type' => 'required',
        ]);
    
        // Create a new User instance and save it to the database
        $user = new User();
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->school_id = $request->school_id;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->password = bcrypt($request->school_id); // Hash the password
        $user->type = $request->type;
        $user->save();
    
        // Redirect back to the index page with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {
        return response()->view('users.users_show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users_layout.users_list', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if($user->type === 'technician librarian') {
        $user->update($request->all()); 

        return redirect()->route('users.index')->with('success','User successfully updated!');
        }
        else if($user->type === 'staff librarian') {
            $user->update($request->all()); 

            return redirect()->route('staff.home')->with('success','User successfully updated!');
        }

        else if($user->type === 'department representative') {
            $user->update($request->all()); 

            return redirect()->route('representative.home')->with('success','User successfully updated!');
        }

        else if($user->type === 'teacher') {
            $user->update($request->all()); 

            return redirect()->route('teacher.home')->with('success','User successfully updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
       
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted!');
    }

    public function confirmDestroy(Request $request){
        $request->validate([
            'password' => 'required',
            'id' => 'required|exists:users,id'
        ]);
        
        $user = auth()->user();

        if (Hash::check($request->password, $user->password)){
            $user = User::findorFail($request->id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted!');
        }
       
        return redirect()->route('users.index')->with('error', 'Incorrect password');
    }

    public function restorePassword(User $user)
    {
        // Update the password of the specific user
        $user->update([
            'password' => $user->school_id,
        ]);
    
        // Redirect back to the index page with a success message
        return redirect()->route('users.index')->with('success', 'Password restored for user ' . $user->id);
    }
    

    public function editAccount(User $user){
        $user = Auth::user();
            if ($user->id == auth()->user()->id){
                $user = Auth::user();
                return view('users_layout.edit_account', ['user'=>$user]);
            }
            else{
                return redirect()->back();
            }
    }

    public function changePassword(User $user){
        $user = Auth::user();
            if ($user->id == auth()->user()->id){
                $user = Auth::user();
                
                return view('users_layout.change_password', ['user'=>$user]);
            }
            else{
                return redirect()->back();
            }
    }

    public function updatePassword(Request $request, User $user)
    {
        $user = Auth::user();
    
        if ($user instanceof User) {
            // Validate the request data
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
    
            // Hash the new password
            $hashedPassword = Hash::make($request->password);
    
            // Update the user's password
            $user->password = $hashedPassword;
            $user->save();
    
            // Logout the user after password change
            Auth::logout();
    
            // Redirect to the login page
            return redirect()->route('login')->with('success', 'Password updated successfully. Please login with your new password.');
        }
    
        // If user is not authenticated or not an instance of User model, redirect back
        return redirect()->back()->with('error', 'Unable to update password.');
    }

    

   

    
}

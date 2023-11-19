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
        if($user->type === 'technician librarian') {
            if (request('search')) {
            $users = User::where('first_name', 'like', '%' . request('search') . '%')
            ->orWhere('middle_name', 'like', '%' . request('search') . '%')
            ->orWhere('last_name', 'like', '%' . request('search') . '%')
            ->orWhere('email', 'like', '%' . request('search') . '%')
            ->orWhere('school_id', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            }
        
            else{
            $users = User::paginate(10);
           
            }
        }

        else{
            return redirect()->back();
        }

        $techcount = User::where('type', 'like', '0')->count();

        $userId = Auth::user()->id;

        return view('users_layout.users_list', ['users'=>$users, 'techcount'=>$techcount, 'userId'=>$userId]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users_layout.users_list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'first_name'=>'required',
        'last_name'=>'required',
        'school_id'=>'required|integer|unique:users',
        'email'=>'email|unique:users',
        'contact_number'=>'required|unique:users',
        'type'=>'required']);

        $data = [
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'school_id' => $request->input('school_id'),
            'email' => $request->input('email'),
            'contact_number' => $request->input('contact_number'),
            'password' => $request->input('school_id'),
            'type' => $request->input('type'),
        ];

        User::create($data);

        
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {
        $users = User::find($id);

        return view('users.users_show', compact('user'));
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

    public function restorePassword(){
       $users = User::all();

            foreach ($users as $user){
                $user->update([
                    'password' => $user->school_id,
                ]);
            }
            return redirect()->route('users.index')->with('success', 'Password restored');
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
            if ($user->id == auth()->user()->id){
                $user->update($request->all()); 

        Auth::logout();

        return redirect()->route('login');
            }

        else{
            return redirect()->back();
        }
    }

    

   

    
}

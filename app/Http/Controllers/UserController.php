<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Pagination\Paginator;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Paginator::useBootstrap();
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

     

        $techcount = User::where('type', 'like', '0')->count();

        return view('users_layout.users_list', ['users'=>$users, 'techcount'=>$techcount]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users_layout.create_users');
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
        return view('users_layout.users_edit', compact('user'));
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
        $user->update($request->all()); 

        return redirect()->route('users.index')->with('success','User successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted!');
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

    public function updatePasswordBlade(User $user)
    {
        return view('users_layout.change_password', compact('user'));
    }

   

    
}

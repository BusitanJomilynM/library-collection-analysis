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

        if(request('search')) { 
            $users = User::where('type', '=', '0' . request('search') . 'technician librarian')->paginate(10)->withQueryString();
        }

        if(request('search')) { 
            $users = User::where('type', '=', '1' . request('search') . 'staff librarian')->paginate(10)->withQueryString();
        }

        if(request('search')) { 
            $users = User::where('type', '=', '2' . request('search') . 'department representative')->paginate(10)->withQueryString();
        }

        return view('users_layout.users_list', ['users'=>$users]);
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
    public function store(StoreUserRequest $request)
    {
        User::create($request->all());
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

    
}

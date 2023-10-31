<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Requisition;

use Illuminate\Http\Request;

class HomeController extends Controller

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {

        //
    } 

    public function technicianHome()
    {

        $user = Auth::user();
        $requisitions = Requisition::all();
        $pending = Requisition::where('status', 'like', '0')->count();

        return view('technicianHome',  ['user'=>$user, 'requisitions'=>$requisitions, 'pending'=>$pending]);
    } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function staffHome()
    {

        $user = Auth::user();
        return view('staffHome',  ['user'=>$user]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function representativeHome()
    {
        
        $user = Auth::user();
        $requisitions = Requisition::all();
        $pending = Requisition::where('status', 'like', '0')->count();

        return view('representativeHome',  ['user'=>$user, 'requisitions'=>$requisitions, 'pending'=>$pending]);
    }
}

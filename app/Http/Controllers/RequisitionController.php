<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequisitionRequest;
use App\Http\Requests\UpdateRequisitionRequest;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Requisition;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Pagination\Paginator;

class RequisitionController extends Controller
{
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
            if(request('search')) { 
                $requisitions = Requisition::where('book_title', 'like', '%' . request('search') . '%')
                ->orwhere('material_type', 'like', '%' . request('search') . '%')
                ->orwhere('author', 'like', '%' . request('search') . '%')
                ->orwhere('isbn', 'like', '%' . request('search') . '%')
                ->orwhere('publisher', 'like', '%' . request('search') . '%')
                ->orwhere('edition', 'like', '%' . request('search') . '%')
                ->orwhere('source', 'like', '%' . request('search') . '%')
                ->orwhere('user_id', 'like', '%' . request('search') . '%')
                ->orwhere('type', 'like', '%' . request('search') . '%')
                ->orwhere('department', 'like', '%' . request('search') . '%')
                ->orwhere('status', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            }

            else{
            $requisitions = Requisition::paginate(10);
            $user = Auth::user();
            $users = User::all();
            }
        }   

        if($user->type === 'department representative') {
            if(request('search')) { 
                $requisitions = Requisition::where('book_title', 'like', '%' . request('search') . '%')
                ->orwhere('material_type', 'like', '%' . request('search') . '%')
                ->orwhere('author', 'like', '%' . request('search') . '%')
                ->orwhere('isbn', 'like', '%' . request('search') . '%')
                ->orwhere('publisher', 'like', '%' . request('search') . '%')
                ->orwhere('edition', 'like', '%' . request('search') . '%')
                ->orwhere('source', 'like', '%' . request('search') . '%')
                ->orwhere('user_id', 'like', '%' . request('search') . '%')
                ->orwhere('type', 'like', '%' . request('search') . '%')
                ->orwhere('department', 'like', '%' . request('search') . '%')
                ->orwhere('status', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            } 
            else {
                if(auth()->user()){
                    $requisitions = Requisition::where('user_id',auth()->user()->id)->paginate(10);
                    $user = Auth::user();
                    $users = User::all();
                }
            }
        } 
        if($user->type === 'staff librarian') {
            if(request('search')) { 
                $requisitions = Requisition::where('book_title', 'like', '%' . request('search') . '%')
                ->orwhere('material_type', 'like', '%' . request('search') . '%')
                ->orwhere('author', 'like', '%' . request('search') . '%')
                ->orwhere('isbn', 'like', '%' . request('search') . '%')
                ->orwhere('publisher', 'like', '%' . request('search') . '%')
                ->orwhere('edition', 'like', '%' . request('search') . '%')
                ->orwhere('source', 'like', '%' . request('search') . '%')
                ->orwhere('user_id', 'like', '%' . request('search') . '%')
                ->orwhere('type', 'like', '%' . request('search') . '%')
                ->orwhere('department', 'like', '%' . request('search') . '%')
                ->orwhere('status', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            }

            else{
            $requisitions = Requisition::paginate(10);
            $user = Auth::user();
            $users = User::all();
            }
        }   

        
        $users = User::all();

        return view('requisitions_layout.requisitions_list', ['requisitions'=>$requisitions, 'user'=>$user, 'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('requisitions_layout.create_requisitions', ['user'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequisitionRequest $request)
    {
        Requisition::create($request->all());
        return redirect()->route('requisitions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisition $requisition)
    {   
        $user = Auth::user();
            if ($requisition->user_id == auth()->user()->id){
                $user = Auth::user();
                    return view('requisitions_layout.requisitions_edit', compact('requisition'), ['user'=>$user]);}
            else{
                return redirect()->back();
            }
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequisitionRequest $request, Requisition $requisition)
    {
        $requisition->update($request->all()); 

        return redirect()->route('requisitions.index')->with('success','Requisition successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisition $requisition)
    {
        $requisition->delete();

        return redirect()->route('requisitions.index')->with('success', 'Requisition deleted!');
    }

    public function changeStatus(Request $request, Requisition $requisition)
    {
        $requisition->status = 1;
        $requisition->save();
             
        return redirect()->route('requisitions.index')->with('success', 'Requisition accepted');
    }

    public function changeStatus2(Request $request, Requisition $requisition)
    {
        $requisition->status = 2;
        $requisition->save();

        return redirect()->route('requisitions.index')->with('success', 'Requisition declined');
    }

    public function pendingRequisitions()
    {
        $users = User::all();

        if(request('search')) { 
            $pending= Requisition::where('book_title', 'like', '%' . request('search') . '%')
            ->orwhere('material_type', 'like', '%' . request('search') . '%')
            ->orwhere('author', 'like', '%' . request('search') . '%')
            ->orwhere('isbn', 'like', '%' . request('search') . '%')
            ->orwhere('publisher', 'like', '%' . request('search') . '%')
            ->orwhere('edition', 'like', '%' . request('search') . '%')
            ->orwhere('source', 'like', '%' . request('search') . '%')
            ->orwhere('user_id', 'like', '%' . request('search') . '%')
            ->orwhere('type', 'like', '%' . request('search') . '%')
            ->orwhere('department', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
        }

        else{
            $pending = Requisition::where('status', 'like', '0')->paginate(10);
        }

        return view('requisitions_layout.pending_requisitions', ['pending'=>$pending, 'users'=>$users]);
    }

   
}

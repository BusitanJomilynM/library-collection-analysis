<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subjecttag;
use App\Models\Book;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UpdateBookRequest;

use Illuminate\Pagination\Paginator;

class SubjecttagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $users = User::all();
        $books = Book::all();
        Paginator::useBootstrap();
        if($user->type === 'technician librarian') {
            if(request('search')) { 
                $Subjecttags = subjecttag::where('book_barcode', 'like', '%' . request('search') . '%')
                ->orwhere('department', 'like', '%' . request('search') . '%')
                ->orwhere('suggest_book_subject', 'like', '%' . request('search') . '%')
                ->orwhere('status', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            }

            else if(request('department')){
                $department = $request->input('department');
        
                $Subjecttags = subjecttag::where('department', $department)->paginate(10)->withQueryString();
            }

            else{
            $subjecttag = Subjecttag::paginate(10);
            $user = Auth::user();
            $users = User::all();
            }
        }   

        if($user->type === 'department representative') {
            if(request('search')) { 
                $tags = Tag::where('book_barcode', 'like', '%' . request('search') . '%')
                ->orwhere('department', 'like', '%' . request('search') . '%')
                ->orwhere('suggest_book_subject', 'like', '%' . request('search') . '%')
                ->orwhere('status', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            } 
            else {
                if(auth()->user()){
                    $tags = Tag::where('user_id',auth()->user()->id)->paginate(10);
                    $user = Auth::user();
                  
                }
            }
        }

        if($user->type === 'staff librarian') {
            if(request('search')) { 
                $tags = Tag::where('book_barcode', 'like', '%' . request('search') . '%')
                ->orwhere('department', 'like', '%' . request('search') . '%')
                ->orwhere('suggest_book_subject', 'like', '%' . request('search') . '%')
                ->orwhere('status', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            }

            else if(request('department')){
                $department = $request->input('department');
        
                $tags = Tag::where('department', $department)->paginate(10)->withQueryString();
            }

            else{
            $tags = Tag::paginate(10);
            $user = Auth::user();
            $users = User::all();
            }
        }  

        return view('tags_layout.tags_list', ['tags'=>$tags, 'user'=>$user, 'users'=>$users, 'books'=>$books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

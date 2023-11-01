<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Book;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        Paginator::useBootstrap();
        if($user->type === 'technician librarian') {
            if(request('search')) { 
                $tags = Tag::where('book_barcode', 'like', '%' . request('search') . '%')
                ->orwhere('department', 'like', '%' . request('search') . '%')
                ->orwhere('suggest_book_subject', 'like', '%' . request('search') . '%')
                ->orwhere('status', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
            }

            else{
            $tags = Tag::paginate(10);
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

            else{
            $tags = Tag::paginate(10);
            $user = Auth::user();
            $users = User::all();
            }
        }  

        return view('tags_layout.tags_list', ['tags'=>$tags, 'user'=>$user, 'users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $bookBarcode = $request->input('book_barcode'); // Retrieve the book_barcode from the query parameter
        $user = Auth::user();
    
        return view('tags_layout.create_tags', ['user' => $user, 'bookBarcode' => $bookBarcode]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $bookBarcode = Book::where('book_barcode', $request->input('book_barcode'))->value('book_barcode');

        $tag = new Tag();
        $tag->book_barcode = $bookBarcode;
    
        $tag->department = $request->input('department');
        $tag->suggest_book_subject = $request->input('suggest_book_subject');
        $tag->user_id = $user->id;
    
        $tag->save();

        
    
        return redirect()->route('tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $user = Auth::user();
        if($user->type === 'department representative') {
            return view('tags_layout.tags_edit', compact('tag'), ['user'=>$user]);
        }
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
    public function update(Request $request, Tag $tag)
    {
        $tag->update($request->all()); 

        return redirect()->route('tags.index')->with('success','Tag successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Tag deleted!');
    }

    public function accept(Request $request, Tag $tag)
    {
        $tag->status = 1;
        $tag->save();
             
        return redirect()->route('tags.index')->with('success', 'Tag accepted');
    }

    public function decline(Request $request, Tag $tag)
    {
        $tag->status = 2;
        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag declined');
    }

    public function pendingTags()
    {
        $users = User::all();

        if(request('search')) { 
            $pending2= Tag::where('book_barcode', 'like', '%' . request('book_barcode') . '%')
            ->orwhere('suggest_book_subject', 'like', '%' . request('suggest_book_subject') . '%')
            ->orwhere('department', 'like', '%' . request('search') . '%')->paginate(5)->withQueryString();
        }

        else{
            $pending2 = Tag::where('status', 'like', '0')->paginate(10);
        }

        return view('tags_layout.pending_tags', ['pending2'=>$pending2, 'users'=>$users]);
    }

}

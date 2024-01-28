<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Book;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Subject;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;


class TagController extends Controller
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $users = User::all();
        $books = Book::all();
        $subjects = Subject::all();
        Paginator::useBootstrap();
        if($user->type === 'technician librarian') {
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

        if($user->type === 'teacher') {
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

        return view('tags_layout.tags_list', ['tags'=>$tags, 'user'=>$user, 'users'=>$users, 'books'=>$books, 'subjects'=>$subjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $books = Book::all();
        $bookBarcode = $request->input('book_barcode'); // Retrieve the book_barcode from the query parameter
        $user = Auth::user();
    
        return view('books_layout.books_list', ['user' => $user, 'bookBarcode' => $bookBarcode, 'books' => $books]);
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
        $tag['suggest_book_subject'] = json_encode($request->suggest_book_subject);
        $tag->action = $request->input('action');
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
            return view('tags_layout.tags_list', compact('tag'), ['user'=>$user]);
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

    public function pendingTags(Request $request)
    {
        $users = User::all();
        $books = Book::all();

        if(request('search')) { 
            $pending2= Tag::where('book_barcode', 'like', '%' . request('book_barcode') . '%')
            ->orwhere('suggest_book_subject', 'like', '%' . request('suggest_book_subject') . '%')
            ->orwhere('department', 'like', '%' . request('search') . '%')->paginate(5)->withQueryString();
        }

        else if(request('department')){
            $department = $request->input('department');
    
            $pending2 = Tag::where('department', $department)->paginate(10)->withQueryString();
        }

        else{
            $pending2 = Tag::where('status', 'like', '0')->paginate(10);
        }

        return view('tags_layout.pending_tags', ['pending2'=>$pending2, 'users'=>$users, 'books'=>$books]);
    }

    public function updateTags(Request $request, Book $book){

        $users = User::all();
        $books = Book::all();
        $tags = Tag::all();

        return view('tags_layout.change_tags', ['books'=>$books,'tags'=>$tags, 'users'=>$users]);
    }

    public function append(Request $request,$tag, $book){
      
        
        $book = Book::findorFail($book);
        $tag = Tag::findorFail($tag);

        $x = $book->book_subject;
        $y = $tag->suggest_book_subject;

        $array1 = json_decode($x, true);
        $array2 = json_decode($y, true);
     

    
        $resultArray = array_merge($array1, $array2);
        $book->book_subject = json_encode($resultArray);
        

        $tag->status = 1;

        $book->save();
        $tag->save();
        

        return redirect()->back()->with('success', 'Tags appended');
    }

    public function replace(Request $request, $tag, $book){
      
        
        $book = Book::findorFail($book);
        $tag = Tag::findorFail($tag);

        $book->book_subject = $tag->suggest_book_subject;

        $book->save();

        $tag->status = 1;
        $tag->save();

        return redirect()->back()->with('success', 'Tags replaced');
    }

}

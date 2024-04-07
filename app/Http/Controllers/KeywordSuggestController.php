<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\KeywordSuggest;
use App\Models\User;
use App\Models\Keyword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KeywordSuggestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keywordsuggest = KeywordSuggest::paginate(10);
        $keywords = Keyword::all();
        $user = Auth::user();
        $users = User::all();
        $books = Book::all();

        return view('keywordsuggest_layout.keywordsuggest_list', ['user'=>$user, 'users'=>$users, 'books'=>$books, 'keywords'=>$keywords, 'keywordsuggest'=>$keywordsuggest]);
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

        return view('keywordsuggest_layout.keywordsuggest_list', ['user'=>$user, 'books'=>$books, 'bookBarcode' => $bookBarcode]);
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

        $keywordsuggest = new KeywordSuggest();
        $keywordsuggest->book_barcode = $bookBarcode;
    
        $keywordsuggest->department = $request->input('department');
        $keywordsuggest['suggest_book_keyword'] = json_encode($request->suggest_book_keyword);
        $keywordsuggest->action = $request->input('action');
        $keywordsuggest->user_id = $user->id;
    
        $keywordsuggest->save();

        
    
        return redirect()->route('keywordsuggest.index');
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
    public function edit(KeywordSuggest $keywordSuggest)
    {
        $user = Auth::user();
        if($user->type === 'department representative' || $user->type === 'teacher') {
            return view('keywordsuggest_layout.keywordsuggest_list', compact('keywordsuggest'), ['user'=>$user]);
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
    public function update(Request $request, KeywordSuggest $keywordsuggest)
    {
        $keywordsuggest->update($request->all()); 

        return redirect()->route('keywordsuggest.index')->with('success','Request successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(KeywordSuggest $keywordsuggest)
    {
        $keywordsuggest->delete();

        return redirect()->route('keywordsuggest.index')->with('success', 'Request deleted!');
    }

    public function appendKeyword(Request $request,$keywordsuggest, $book){
      
        
        $book = Book::findorFail($book);
        $keywordsuggest = KeywordSuggest::findorFail($keywordsuggest);

        $x = $book->book_subject;
        $y = $keywordsuggest->suggest_book_keyword;

        $array1 = json_decode($x, true);
        $array2 = json_decode($y, true);
     

    
        $resultArray = array_merge($array1, $array2);
        $book->book_keyword = json_encode($resultArray);
        

        $keywordsuggest->status = 1;

        $book->save();
        $keywordsuggest->save();
        

        return redirect()->back()->with('success', 'Keywords appended');
    }

    public function replacekeyword(Request $request, $keywordsuggest, $book){
      
        $book = Book::findorFail($book);
        $keywordsuggest = KeywordSuggest::findorFail($keywordsuggest);

        $book->book_keyword = $keywordsuggest->suggest_book_keyword;

        $book->save();

        $keywordsuggest->status = 1;
        $keywordsuggest->save();

        return redirect()->back()->with('success', 'Keywords replaced');
    }

    public function declinekeyword(Request $request, KeywordSuggest $keywordsuggest)
    {
        $keywordsuggest->status = 2;
        $keywordsuggest->save();

        return redirect()->route('keywordsuggest.index')->with('success', 'Request declined');
    }
}

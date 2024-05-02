<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\KeywordSuggest;
use App\Models\User;
use App\Models\Keyword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class KeywordSuggestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(request('search')) { 
            $keywordsuggest = KeywordSuggest::where('book_barcode', 'like', '%' . request('search') . '%')
            ->orwhere('department', 'like', '%' . request('search') . '%')
            ->orwhere('suggest_book_keyword', 'like', '%' . request('search') . '%')
            ->orwhere('book_barcode', 'like', '%' . request('search') . '%')
            ->orwhere('status', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();

            $department = $request->input('department');
            $keywords = Keyword::all();
            $user = Auth::user();
            $users = User::all();
            $books = Book::all();
        }

        else if(request('department')){
            $department = $request->input('department');
            $keywords = Keyword::all();
            $user = Auth::user();
            $users = User::all();
            $books = Book::all();
    
            $keywordsuggest = KeywordSuggest::where('department', $department)->paginate(10)->withQueryString();
        }

        else{
            $keywordsuggest = KeywordSuggest::paginate(10);
            $keywords = Keyword::all();
            $user = Auth::user();
            $users = User::all();
            $books = Book::all();
        }

        


        Paginator::useBootstrap();
        

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

    public function declinekeyword(Request $request, KeywordSuggest $keywordsuggest)
    {
        $keywordsuggest->status = 2;
        $keywordsuggest->save();

        return redirect()->route('keywordsuggest.index')->with('success', 'Request declined');
    }

    public function appendKeyword(Request $request, $keywordsuggest, $book){
  
        $book = Book::findOrFail($book);
        $keywordsuggest = KeywordSuggest::findOrFail($keywordsuggest);
    
        $booksWithSameCallNumber = Book::where('book_callnumber', $book->book_callnumber)->get();
    
        foreach ($booksWithSameCallNumber as $matchingBook) {
            $x = json_decode($matchingBook->book_keyword, true) ?? [];
            $y = json_decode($keywordsuggest->suggest_book_keyword, true) ?? [];
    
            // Merge two arrays
            $resultArray = array_merge($x, $y);
    
            // Remove duplicate values
            $resultArray = array_unique($resultArray);
    
            // Convert the array back to JSON
            $matchingBook->book_keyword = json_encode($resultArray);
            $matchingBook->save();
        }
    
        $keywordsuggest->status = 1;
        $keywordsuggest->save();
    
        return redirect()->back()->with('success', 'Keywords appended to all matching books');
    }
    
    

public function replacekeyword(Request $request, $keywordsuggest, $book){
  
    $book = Book::findOrFail($book);
    $keywordsuggest = KeywordSuggest::findOrFail($keywordsuggest);

    $booksWithSameCallNumber = Book::where('book_callnumber', $book->book_callnumber)->get();

    foreach ($booksWithSameCallNumber as $matchingBook) {
        $matchingBook->book_keyword = $keywordsuggest->suggest_book_keyword;
        $matchingBook->save();
    }

    $keywordsuggest->status = 1;
    $keywordsuggest->save();

    return redirect()->back()->with('success', 'Keywords replaced for all matching books');
}

}

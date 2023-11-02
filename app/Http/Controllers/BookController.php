<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Book;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Pagination\Paginator;
use Barryvdh\DomPDF\Facade\Pdf;
use Codedge\Fpdf\Fpdf\Fpdf;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $user = Auth::user();
    $books = Book::paginate(10);
    Paginator::useBootstrap();

    if($user->type === 'technician librarian') {
        if(request('search')) {
            $books = Book::where('book_title', 'like', '%' . request('search') . '%')
            ->orwhere('book_callnumber', 'like', '%' . request('search') . '%')
            ->orwhere('book_barcode', 'like', '%' . request('search') . '%')
            ->orwhere('book_author', 'like', '%' . request('search') . '%')
            ->orwhere('book_copyrightyear', 'like', '%' . request('search') . '%')
            ->orwhere('book_sublocation', 'like', '%' . request('search') . '%')
            ->orwhere('book_subject', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
        } 
    
        else{
        $books = Book::paginate(10);
        }
    }

    $user = Auth::user();
    if($user->type === 'staff librarian') {
        if(request('search')) {
            $books = Book::where('book_title', 'like', '%' . request('search') . '%')
            ->orwhere('book_callnumber', 'like', '%' . request('search') . '%')
            ->orwhere('book_barcode', 'like', '%' . request('search') . '%')
            ->orwhere('book_author', 'like', '%' . request('search') . '%')
            ->orwhere('book_copyrightyear', 'like', '%' . request('search') . '%')
            ->orwhere('book_sublocation', 'like', '%' . request('search') . '%')
            ->orwhere('book_subject', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
        } 
    
        else{
        $books = Book::paginate(10);
        }
    }

    $user = Auth::user();
    if($user->type === 'department representative') {
        if(request('search')) {
            $books = Book::where('book_title', 'like', '%' . request('search') . '%')
            ->orwhere('book_callnumber', 'like', '%' . request('search') . '%')
            ->orwhere('book_barcode', 'like', '%' . request('search') . '%')
            ->orwhere('book_author', 'like', '%' . request('search') . '%')
            ->orwhere('book_copyrightyear', 'like', '%' . request('search') . '%')
            ->orwhere('book_sublocation', 'like', '%' . request('search') . '%')
            ->orwhere('book_publisher', 'like', '%' . request('search') . '%')
            ->orwhere('book_lccn', 'like', '%' . request('search') . '%')
            ->orwhere('book_isbn', 'like', '%' . request('search') . '%')
            ->orwhere('book_edition', 'like', '%' . request('search') . '%')
            ->orwhere('book_subject', 'like', '%' . request('search') . '%')->paginate(10)->withQueryString();
        } 
    
        else{
        $books = Book::paginate(10);
        }
    }
    

        return view('books_layout.books_list', ['books'=>$books,'user'=>$user]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $tags=DB::table('tags')->get();
        $user = Auth::user();
        if($user->type === 'technician librarian') {
            return view('books_layout.create_books');
        }
        else{
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        Book::create($request->all());
        return redirect()->route('books.index');
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
    public function edit(Book $book)
    {
        $user = Auth::user();
        if($user->type === 'technician librarian') {
            return view('books_layout.books_edit', compact('book'));
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
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->all()); 

        return redirect()->route('books.index')->with('success','Book successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $user = Auth::user();
        if($user->type === 'technician librarian') {
        $book->delete();
            return redirect()->route('books.index')->with('success', 'Book deleted!');
        }
        else{
            return redirect()->back();
        }
    }

    public function createPDFBook() {
        // retreive all records from db    
            $books = Book::where('book_tag', 'like', '%' . request('search') . '%')->get();
            $pdf = pdf::loadView('books_layout.pdf_view', compact('books'))->setPaper('a4', 'landscape');

            return $pdf->stream('book_report.pdf');    
    }

    public function archiveBook(Request $request, Book $book){

        $book->status=1;
        $book->book_barcode="";
        $book->save();

        return redirect()->route('books.index')->with('success','Book archived');
    }

    public function restoreBook(Request $request, Book $book){

        $book->update($request->all()); 

        return view('books_layout.restore_books', ['book'=>$book]);
    }

    public function restoreUpdate(Request $request, Book $book)
    {
        $book->update($request->all()); 

        return redirect()->route('archive')->with('success','Book restored');
    }

    public function archive(){

        $user = Auth::user();
        if($user->type === 'technician librarian') {
        $archives = Book::where('status', 'like', '1')->paginate(10);
        }
        elseif($user->type === 'staff librarian') {
        $archives = Book::where('status', 'like', '1')->paginate(10);
        }
        else{
            return redirect()->back();
        }

        return view('books_layout.archived_books', ['archives'=>$archives,'user'=>$user]);

    }
    
}

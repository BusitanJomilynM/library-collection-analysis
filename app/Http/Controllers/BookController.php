<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Requests\UpdateArchiveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Models\Book;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Pagination\Paginator;
//  use Barryvdh\DomPDF\Facade\Pdf;
// use Codedge\Fpdf\Fpdf\Fpdf;
 use Barryvdh\DomPDF\Facade as PDF;
//  use PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\archiveUpdate;


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
        $user = Auth::user();
        if ($user->type === 'technician librarian') {
            $barcode = $this->generateUniqueBarcode();
            return view('books_layout.create_books', compact('barcode'));
        } else {
            return redirect()->back();
        }
    }

    protected function generateUniqueBarcode() {
        $barcode = 'T' . rand(1, 99999);
    
        // Check if the generated barcode already exists in the database
        while (Book::where('book_barcode', $barcode)->exists()) {
            $barcode = 'T' . rand(1, 99999);
        }
    
        return $barcode;
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
    // public function booklistPdf(Request $request, Book $book)
    // {
    //     $showBookTitle = $request->has('booktitle');
    //     $showBookCallnumber = $request->has('bookcallnumber');
    //     $showBookAuthor = $request->has('bookauthor'); 
    //     $showBookCopyrightYear = $request->has('bookcopyrightyear'); 
        
    
    //     if ($showBookTitle || $showBookCallnumber ||  $showBookAuthor || $showBookCopyrightYear) {
    //         $data = Book::all();
    
    //         $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('books_layout.pdf_view', compact('data', 'showBookTitle', 'showBookCallnumber', 'showBookAuthor', 'showBookCopyrightYear'))->setPaper('a4', 'landscape');
    
    //         return $pdf->stream('book_report.pdf');
    //     }
    
    //     // Default case (when no checkbox is selected)
    //     return view('books_layout.booklist_pdf', ['books' => $book]);
    // }
    public function booklistPdf(Request $request, Book $book)
{
    $showBookTitle = $request->has('booktitle');
    $showBookCallnumber = $request->has('bookcallnumber');
    $showBookAuthor = $request->has('bookauthor'); 
    $showBookCopyrightYear = $request->has('bookcopyrightyear'); 

    if ($showBookTitle || $showBookCallnumber || $showBookAuthor || $showBookCopyrightYear) {
        $data = Book::all();
        
        // Group books by call number
        $groupedBooks = $data->groupBy('book_callnumber');

        $data = [];

        foreach ($groupedBooks as $callnumber => $books) {
            // Count the number of non-archived books for each call number
            $nonArchivedBooks = $books->reject(function ($book) {
                return $book->status == 1; // Assuming status 1 represents archived books
            });

            $copyCount = $nonArchivedBooks->count();

            // If there are non-archived books, add the first one to the PDF data
            if ($copyCount > 0) {
                $firstBook = $nonArchivedBooks->first();
                $data[] = [
                    'title' => $firstBook->book_title,
                    'callnumber' => $callnumber,
                    'author' => $firstBook->book_author,
                    'copyrightyear' => $firstBook->book_copyrightyear,
                    'copy_count' => $copyCount,
                ];
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('books_layout.pdf_view', compact('data', 'showBookTitle', 'showBookCallnumber', 'showBookAuthor', 'showBookCopyrightYear'))->setPaper('a4', 'landscape');
        return $pdf->stream('book_report.pdf');
    }

    // Default case (when no checkbox is selected)
    return view('books_layout.booklist_pdf', ['books' => $book]);
}

    public function archiveBook(UpdateArchiveRequest $request, Book $book){

        $book->status=1;
        $book->update(['book_barcode'=>null]);
        $book->update($request->all()); 
        $book->save();

        return view('books_layout.archive_books', ['book'=>$book]);
    }

    public function archiveUpdate(UpdateArchiveRequest $request, Book $book)
    {
        $book->update($request->all()); 

        return redirect()->route('archive')->with('success','Book archived');
    }

    public function restoreBook(Request $request, Book $book){

        $book->update(['archive_reason'=>null]);
        $barcode = $this->generateUniqueBarcode();

        $book->update($request->all()); 

        return view('books_layout.restore_books', ['book'=>$book], compact('barcode'));
    }

    public function restoreUpdate(UpdateBookRequest $request, Book $book)
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
    public function view_bookdetails(Book $book)
    {
            return view('books_layout.view_bookdetails', compact('book'));

    }

        public function book_createcopy(Request $request, Book $book)
        {
            $barcode = $this->generateUniqueBarcode();
            return view('books_layout.book_createcopy', compact('book','barcode'));
        }

    

    
    public function validateMaterialType(Request $request)
    {
        $request->validate([
            'material_type' => 'required|in:Book,JournalMagazine,DocumentaryFilm,DVDVCD,MapsGlobes,Other',
            'other_material_type' => Rule::requiredIf(function () use ($request) {
                return $request->input('material_type') == 'Other';
            }) . '|min:2|max:40',
        ], [
            'other_material_type.required' => 'The Other field is required when Material Type is Other.',
        ]);

    }

    
}

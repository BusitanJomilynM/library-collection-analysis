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
    $books = Book::paginate(10);

 
    $barcode = $this->generateUniqueBarcode();
    $bookBarcode = $request->input('book_barcode'); // Retrieve the book_barcode from the query parameter
    
    Paginator::useBootstrap();
    

        if(request('search')) {
            $books = Book::where('book_title', 'like', '%' . request('search') . '%')
            ->orwhere('book_callnumber', 'like', '%' . request('search') . '%')
            ->orwhere('book_barcode', 'like', '%' . request('search') . '%')
            ->orwhere('book_author', 'like', '%' . request('search') . '%')
            ->orwhere('book_copyrightyear', 'like', '%' . request('search') . '%')
            ->orwhere('book_sublocation', 'like', '%' . request('search') . '%')
            ->orwhere('book_subject', 'like', '%' . request('search') . '%')->orderBy('book_title','asc')->paginate(10)->withQueryString();
        } 
    
        else{
        $books = Book::orderBy('book_title','asc')->paginate(10);
        }

        return view('books_layout.books_list', ['books'=>$books,'user'=>$user, 'barcode'=>$barcode, 'bookBarcode'=>$bookBarcode]);
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
            return view('books_layout.books_list', ['barcode'=>$barcode]);
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
            return view('books_layout.view_bookdetails', compact('book'));
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
            return redirect()->route('archive')->with('success', 'User Deleted');
        }
        else{
            return redirect()->back();
        }
    }

        
    public function archiveBook(UpdateArchiveRequest $request, Book $book){
        $book->update($request->all()); 
        return view('books_layout.view_bookdetails', ['book'=>$book]);
    }

    public function archiveUpdate(UpdateArchiveRequest $request, Book $book)
    {

        $book->status=1;
        $book->update(['book_barcode'=>null]);
        $book->update($request->all()); 
        $book->save();
        return redirect()->route('archive')->with('success','Book archived');
    }

    public function restoreBook(Request $request, Book $book){

        $book->update(['archive_reason'=>null]);
        $barcode = $this->generateUniqueBarcode();
        $book->book_barcode = $barcode;
        $book->status=0;
        $book->update($request->all()); 
        $book->save();
        
        return redirect()->route('archive')->with('success','Book restored');
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
        $barcode = $this->generateUniqueBarcode();
            $user = Auth::user();
            return view('books_layout.view_bookdetails', compact('book','user','barcode'));

    }

    
    public function book_createcopy(Request $request, Book $book)
    {
        $barcode = $this->generateUniqueBarcode();
        return view('books_layout.view_bookdetails', compact('book','barcode'));
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
    public function booklistPdf(Request $request, Book $book)
    {
        $pdfTitle = $request->input('pdfTitle');
        $subtitle = $request->input('subtitle');
        $courseCode = $request->input('courseCode');
        $courseDescription = $request->input('courseDescription');
    

        $user = Auth::user();
        $showBookTitle = $request->has('booktitle');
        $showBookCallnumber = $request->has('bookcallnumber');
        $showBookAuthor = $request->has('bookauthor');
        $showBookCopyrightYear = $request->has('bookcopyrightyear');
        $showVolume = $request->has('volume');
        
        // Check if the includeYearRange checkbox is checked
        $includeYearRange = $request->has('includeYearRange');
        
        // Get the start and end years from the request
        $startYear = $request->input('startYear');
        $endYear = $request->input('endYear');
        
        // New checkboxes for subject
        $showSubject = $request->has('subject');
        $subjectText = $request->input('subjectText');
    
        // Check if there is a space in the entered subject text
        $subjectTexts = (strpos($subjectText, ' ') !== false) ? explode(' ', $subjectText) : [$subjectText];
    
        // New select box for callNumberPrefix
        $callNumberPrefix = $request->input('callNumberPrefix');
    
        if ($showBookTitle || $showBookCallnumber || $showBookAuthor || $showBookCopyrightYear || $showSubject || $callNumberPrefix) {
            $data = Book::query();
    
            // Filter the books based on the year range if provided
            if ($includeYearRange && is_numeric($startYear) && is_numeric($endYear)) {
                $data = $data->whereBetween('book_copyrightyear', [$startYear, $endYear]);
            }
    
            // Filter books based on multiple subjects
// Filter books based on multiple subjects
if ($showSubject && !empty($subjectTexts)) {
    $data = $data->where(function ($query) use ($subjectTexts) {
        foreach ($subjectTexts as $subjectText) {
            $query->orWhere('book_callnumber', 'like', $subjectText . '%');
        }
    });
}

    
            // Filter books based on callNumberPrefix
            if ($callNumberPrefix) {
                $data = $data->where('book_callnumber', 'like', $callNumberPrefix . '%');
            }
    
            $data = $data->get();
    
            $resultData = [];
    
            foreach ($data as $book) {
                if ($book->status != 1) { // Assuming status 1 represents archived books
                    $key = $book->book_callnumber;
    
                    if (!isset($resultData[$key])) {
                        // If the book is not in the resultData array, add it with a copy count of 1
                        $resultData[$key] = [
                            'title' => $book->book_title,
                            'callnumber' => $book->book_callnumber,
                            'author' => $book->book_author,
                            'copyrightyear' => $book->book_copyrightyear,
                            'volume' => $book->book_volume ? 1 : 0,
                            'copy_count' => 1,
                        ];
                    } else {
                        // If the book is already in the resultData array, increment the copy count
                        $resultData[$key]['copy_count']++;
                    }
                }
            }

            if (!$showVolume) {
                $resultData = array_filter($resultData, function ($book) {
                    return $book['volume'] > 0;
                });
            }
        
            $totalCopyCount = array_sum(array_column($resultData, 'copy_count'));
            $totalVolume = $showVolume ? array_sum(array_column($resultData, 'volume')) : null;
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('books_layout.pdf_view', compact('resultData', 'showBookTitle', 'showBookCallnumber', 'showBookAuthor', 'showBookCopyrightYear', 'showVolume', 'user', 'totalCopyCount', 'totalVolume', 'pdfTitle', 'subtitle', 'courseCode', 'courseDescription'))->setPaper('a4', 'portrait');
            return $pdf->stream('book_report.pdf');
                    }
        
        // Default case (when no checkbox is selected)
        return view('books_layout.booklist_pdf', ['books' => $book]);
    }
    public function collectionanalysisPdf(Request $request, Book $book)
    {
        $pdfTitle = $request->input('pdfTitle');
        $subtitle = $request->input('subtitle');
        $courseCode = $request->input('courseCode');
        $courseDescription = $request->input('courseDescription');
    

        $user = Auth::user();

        $showNumberTitles = $request->has('copy');
        $showVolume = $request->has('volume');
        
        // Check if the includeYearRange checkbox is checked
        $includeYearRange = $request->has('includeYearRange');
        
        // Get the start and end years from the request
        $startYear = $request->input('startYear');
        $endYear = $request->input('endYear');
        
        // New checkboxes for subject
        $showSubject = $request->has('subject');
        $subjectText = $request->input('subjectText');
        $totalTitleCount = 0;
        $totalVolume = 0;
    
        $resultData = [];
    
        // Check if there is a space in the entered subject text
        $subjectTexts = (strpos($subjectText, ' ') !== false) ? explode(' ', $subjectText) : [$subjectText];
    
        // New select box for callNumberPrefix
        $callNumberPrefix = $request->input('callNumberPrefix');
    
        foreach ($resultData as $yearData) {
            $totalTitleCount += $yearData['title_count'];
            // Assuming 'volume' is a property of the book model, adjust this accordingly
            if ($showVolume) {
                // Calculate the sum of volumes for each year
                $totalVolume += $this->calculateTotalVolume($yearData['year']);
            }
        }

        if ($showSubject || $callNumberPrefix) {
            $data = Book::query();
    
            // Filter the books based on the year range if provided
            if ($includeYearRange && is_numeric($startYear) && is_numeric($endYear)) {
                $data = $data->whereBetween('book_copyrightyear', [$startYear, $endYear]);
            }
    
            // Filter books based on multiple subjects
            if ($showSubject && !empty($subjectTexts)) {
                $data = $data->where(function ($query) use ($subjectTexts) {
                    foreach ($subjectTexts as $subjectText) {
                        $query->orWhere('book_subject', 'like', '%' . $subjectText . '%');
                    }
                });
            }
    
            // Filter books based on callNumberPrefix
            if ($callNumberPrefix) {
                $data = $data->where('book_callnumber', 'like', $callNumberPrefix . '%');
            }
    
            // Get the books with distinct call numbers
            $data = $data->distinct('book_callnumber')->get();
    

    
            foreach ($data as $book) {
                if ($book->status != 1) { // Assuming status 1 represents archived books
                    $year = substr($book->book_callnumber, 0, 4);
    
                    if (!isset($resultData[$year])) {
                        // If the year is not in the resultData array, add it with a title count of 1
                        $resultData[$year] = [
                            'year' => $year,
                            'title_count' => 1,
                        ];
                    } else {
                        // If the year is already in the resultData array, increment the title count
                        $resultData[$year]['title_count']++;
                    }
                }
            }
    
            // Sort resultData by year in descending order
            krsort($resultData);
    
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('books_layout.pdf_collection', compact('resultData', 'showVolume', 'showNumberTitles', 'user', 'totalTitleCount', 'totalVolume', 'pdfTitle', 'subtitle', 'courseCode', 'courseDescription'))->setPaper('a4', 'portrait');
            return $pdf->stream('collection_analysis_report.pdf');        }                    
        
        // Default case (when no checkbox is selected)
        return view('books_layout.collection_analysis', ['books' => $book]);
    }
    

    }    
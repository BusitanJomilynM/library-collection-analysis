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
use App\Models\Course;
use App\Models\Keyword;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Pagination\Paginator;
//  use Barryvdh\DomPDF\Facade\Pdf;
// use Codedge\Fpdf\Fpdf\Fpdf;
use Barryvdh\DomPDF\Facade as PDF;
//  use PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Models\archiveUpdate;
use Illuminate\Support\Facades\Log;



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
    $keywords = Keyword::all();
    $subjects = Subject::all();

 
    // $barcode = $this->generateUniqueBarcode();
    // $bookBarcode = $request->input('book_barcode'); // Retrieve the book_barcode from the query parameter
    
    Paginator::useBootstrap();
    

        if(request('search')) {
            $books = Book::where('book_title', 'like', '%' . request('search') . '%')
            ->orwhere('book_callnumber', 'like', '%' . request('search') . '%')
            ->orwhere('book_barcode', 'like', '%' . request('search') . '%')
            ->orwhere('book_author', 'like', '%' . request('search') . '%')
            ->orwhere('book_copyrightyear', 'like', '%' . request('search') . '%')
            ->orwhere('book_sublocation', 'like', '%' . request('search') . '%')
            ->orwhere('book_keyword', 'like', '%' . request('search') . '%')
            ->orwhere('book_subject', 'like', '%' . request('search') . '%')->orderBy('book_title','asc')->paginate(10)->withQueryString();
        } 
    
        else{
        $books = DB::table('books')
                  
                    ->select('*', 'books.id as bookId' )
                    ->paginate(10)->withQueryString();
        }

        // return view('books_layout.books_list', ['books'=>$books,'user'=>$user, 'barcode'=>$barcode, 'bookBarcode'=>$bookBarcode]);
        return view('books_layout.books_list', ['books'=>$books,'user'=>$user, 'keywords'=>$keywords, 'subjects'=>$subjects]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user->type === 'technician librarian') {
            // $barcode = $this->generateUniqueBarcode();
            // return view('books_layout.books_list', ['barcode'=>$barcode]);
            $barcode = null;

            // $book_subject1 = is_array($request->input('book_subject')) ? implode(',', $request->input('book_subject')) : ($request->input('book_subject') ?? '');
            // $book_keyword1 = is_array($request->input('book_keyword')) ? implode(',', $request->input('book_keyword')) : ($request->input('book_keyword') ?? '');            // Save to the database
            // $book = new Book();
            
            // // Do not save individual arrays, save the comma-separated strings
            // $book->book_subject = $book_subject1;
            // $book->book_keyword = $book_keyword1;
            
            // $book->book_callnumber = $request->input('book_callnumber');
            // $book->book_barcode = $request->input('book_barcode');
            // $book->book_title = $request->input('book_title');
            // $book->book_author = $request->input('book_author');
            // $book->book_sublocation = $request->input('book_sublocation');
            // $book->book_volume = $request->input('book_volume');
            // $book->book_publisher = $request->input('book_publisher');
            // $book->book_purchasedwhen = $request->input('book_purchasedwhen');
            // $book->book_lccn = $request->input('book_lccn');
            // $book->book_isbn = $request->input('book_isbn');
            // $book->book_edition = $request->input('book_edition');



            // $book->save();
            
            return view('books_layout.books_list', compact('barcode'));
        } else {
            return redirect()->back();
        }
    }

    public function generateBarcode(Request $request)
    {
        $user = Auth::user();
        if ($user->type === 'technician librarian') {
            $barcode = $this->generateUniqueBarcode();
            // Display the generated barcode in the same view
            return view('books_layout.books_list', ['barcode' => $barcode]);
        } else {
            return redirect()->back();
        }
    }

    protected function generateUniqueBarcode()
    {
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
        // Book::create($request->all());
        // return redirect()->route('books.index');
        $data = $request->all();

        // Split authors by comma and trim any extra whitespaces
        $authors = explode(',', $data['book_author']);
        $authors = array_map('trim', $authors);

        $subjects = $data['book_subject'];
        $subjects = implode(',', array_map('trim', $subjects));

    
        // Remove empty elements from the array
        $authors = array_filter($authors);
    
        $data['book_author'] = implode(', ', $authors);
        if (is_array($data['book_subject'])) {
            $data['book_subject'] = implode(', ', array_map('trim', $data['book_subject']));
        }
        if (is_array($data['book_keyword'])) {
            $data['book_keyword'] = implode(', ', array_map('trim', $data['book_keyword']));
        }


        $data['book_subject'] = json_encode($request->book_subject);
        $data['book_keyword'] = json_encode($request->book_keyword);

    
        Book::create($data);
    
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

        $subjects = Subject::all();

        return view('books_layout.archived_books', ['archives'=>$archives,'user'=>$user, 'subjects'=>$subjects]);

    }
    public function view_bookdetails(Book $book)
    {
        $barcode = $this->generateUniqueBarcode();
            $user = Auth::user();

            $keywords = Keyword::all();
            $subjects = Subject::all();
            
            return view('books_layout.view_bookdetails', compact('book','user','barcode', 'keywords', 'subjects'));

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
        $courses = Course::all();    
        $subjects = Subject::all();  
        $keywords = Keyword::all(); 
        $books = Book::all();    
        $user = Auth::user();
    
        $course_name = $request->input('course');
        $callNumberPrefixes = explode(',', $request->input('callNumberPrefix'));

        $course = Course::where('course_name', $course_name)->first();
        $course_code = $course ? $course->course_code : null;


        $filteredBooksSets = []; // Array to hold filtered books from different sets
        $bookStatsSets = []; // Array to hold book stats for different sets
        $subjectNamesListSets = []; // Array to hold subject names for different sets
        $subjectCodesListSets = []; // Array to hold subject codes for different sets
        
        $setCount = 1;
        while ($request->has("subject_$setCount") && $request->has("keyword_$setCount")) {
            $subjectNames = $request->input("subject_$setCount");
        
            // Initialize subject-specific arrays for each set
            $subjectNamesList = [];
            $subjectCodesList = [];
            $keywordsList = [];
        
            $subject = Subject::where('subject_name', $subjectNames)->first();
            if ($subject) {
                $subjectNamesList[] = $subjectNames;
                $subjectCodesList[] = $subject->subject_code; // Store subject code
                $keywordsList[] = $request->input("keyword_$setCount");
            }
        
            // Filter books for the current set
            $filteredBooks = collect();
            foreach ($books as $book) {
                $jsonSubject = $book->book_subject;
                $subjectArray = json_decode($jsonSubject, true);
                $jsonKeyword = $book->book_keyword;
                $keywordArray = json_decode($jsonKeyword, true);
        
                // Check if any subject name provided by the user matches any subject in the book
                foreach ($subjectNamesList as $subjectName) {
                    if (in_array($subjectName, $subjectArray)) {
                        $filteredBooks->push($book);
                        break; // Once a match is found, break the loop for this book
                    }
                }
        
                // Check if any keyword provided by the user matches any keyword in the book
                foreach ($keywordsList as $keywords) {
                    $keywords = preg_split('/,/', $keywords);
                    foreach ($keywords as $keyword) {
                        if (in_array($keyword, $keywordArray)) {
                            $filteredBooks->push($book);
                            break 2; // Break both inner and outer loop once a match is found
                        }
                    }
                }
            }
        
            // Remove duplicates from filtered books
            $filteredBooks = $filteredBooks->unique('id');
        
            // Store filtered books for the current set
            $filteredBooksSets[$setCount] = $filteredBooks;
        
            // Store subject names and codes for the current set
            $subjectNamesListSets[$setCount] = $subjectNamesList;
            $subjectCodesListSets[$setCount] = $subjectCodesList;
        
            // Calculate book stats for the current set
            $bookStats = [];
            foreach ($filteredBooks as $book) {
                $callNumber = $book->book_callnumber;
        
                if (!isset($bookStats[$callNumber])) {
                    $bookStats[$callNumber] = [
                        'title' => $book->book_title,
                        'call_number' => $book->book_callnumber,
                        'author' => $book->book_author,
                        'totalCopies' => 1,
                        'totalVolumes' => $book->book_volume ? 1 : 0,
                        'copyright' => $book->book_copyrightyear,

                    ];
                } else {
                    $bookStats[$callNumber]['totalCopies'] += 1;
                    if ($book->book_volume) {
                        $bookStats[$callNumber]['totalVolumes'] += 1;
                    }
                }
            }
        
            // Store book stats for the current set
            $bookStatsSets[$setCount] = $bookStats;
        
            $setCount++;
        }
        
        // Now you have filtered books, book stats, subject names, and subject codes for each set
        // You can use $filteredBooksSets, $bookStatsSets, $subjectNamesListSets, and $subjectCodesListSets to pass to the PDF view
        
        if (!empty($filteredBooksSets)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('books_layout.pdf_view', compact('user', 'course_name', 'course_code', 'bookStatsSets', 'filteredBooksSets', 'subjectNamesListSets', 'subjectCodesListSets'))->setPaper('a4', 'portrait');
            return $pdf->stream('book_report.pdf');
        } else {
            return view('books_layout.booklist_pdf', ['books' => $book, 'courses' => $courses, 'subjects' => $subjects, 'keywords' => $keywords]);
        }
            }            
    
            public function collectionAnalysis(Request $request, Book $book)
            {
                $courses = Course::all();    
                $subjects = Subject::all();  
                $keywords = Keyword::all(); 
                $books = Book::all();    
                $user = Auth::user();
            
                $course_name = $request->input('course');
                $callNumberPrefixes = explode(',', $request->input('callNumberPrefix'));
        
                $course = Course::where('course_name', $course_name)->first();
                $course_code = $course ? $course->course_code : null;
        
        
                $filteredBooksSets = []; // Array to hold filtered books from different sets
                $bookStatsSets = []; // Array to hold book stats for different sets
                $subjectNamesListSets = []; // Array to hold subject names for different sets
                $subjectCodesListSets = []; // Array to hold subject codes for different sets
                
                $setCount = 1;
                while ($request->has("subject_$setCount") && $request->has("keyword_$setCount")) {
                    $subjectNames = $request->input("subject_$setCount");
                
                    // Initialize subject-specific arrays for each set
                    $subjectNamesList = [];
                    $subjectCodesList = [];
                    $keywordsList = [];
                
                    $subject = Subject::where('subject_name', $subjectNames)->first();
                    if ($subject) {
                        $subjectNamesList[] = $subjectNames;
                        $subjectCodesList[] = $subject->subject_code; // Store subject code
                        $keywordsList[] = $request->input("keyword_$setCount");
                    }
                
                    // Filter books for the current set
                    $filteredBooks = collect();
                    foreach ($books as $book) {
                        $jsonSubject = $book->book_subject;
                        $subjectArray = json_decode($jsonSubject, true);
                        $jsonKeyword = $book->book_keyword;
                        $keywordArray = json_decode($jsonKeyword, true);
                
                        // Check if any subject name provided by the user matches any subject in the book
                        foreach ($subjectNamesList as $subjectName) {
                            if (in_array($subjectName, $subjectArray)) {
                                $filteredBooks->push($book);
                                break; // Once a match is found, break the loop for this book
                            }
                        }
                
                        // Check if any keyword provided by the user matches any keyword in the book
                        foreach ($keywordsList as $keywords) {
                            $keywords = preg_split('/,/', $keywords);
                            foreach ($keywords as $keyword) {
                                if (in_array($keyword, $keywordArray)) {
                                    $filteredBooks->push($book);
                                    break 2; // Break both inner and outer loop once a match is found
                                }
                            }
                        }
                    }
                
                    // Remove duplicates from filtered books
                    $filteredBooks = $filteredBooks->unique('id');
                
                    // Store filtered books for the current set
                    $filteredBooksSets[$setCount] = $filteredBooks;
                
                    // Store subject names and codes for the current set
                    $subjectNamesListSets[$setCount] = $subjectNamesList;
                    $subjectCodesListSets[$setCount] = $subjectCodesList;
                
                    // Calculate book stats for the current set
                    $bookStats = [];
                    foreach ($filteredBooks as $book) {
                        $callNumber = $book->book_callnumber;
                
                        if (!isset($bookStats[$callNumber])) {
                            $bookStats[$callNumber] = [
                                'totalVolumes' => $book->book_volume ? 1 : 0,
                                'copyright' => $book->book_copyrightyear,
                            ];
                        } else {
                            $bookStats[$callNumber]['totalCopies'] += 1;
                            if ($book->book_volume) {
                                $bookStats[$callNumber]['totalVolumes'] += 1;
                            }
                        }
                    }
                
                    // Store book stats for the current set
                    $bookStatsSets[$setCount] = $bookStats;
                
                    $setCount++;
                }
                
                // Now you have filtered books, book stats, subject names, and subject codes for each set
                // You can use $filteredBooksSets, $bookStatsSets, $subjectNamesListSets, and $subjectCodesListSets to pass to the PDF view
                
                if (!empty($filteredBooksSets)) {
                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('books_layout.pdf_collection', compact('user', 'course_name', 'course_code', 'bookStatsSets', 'filteredBooksSets', 'subjectNamesListSets', 'subjectCodesListSets'))->setPaper('a4', 'landscape');
                    return $pdf->stream('book_report.pdf');
                } else {
                    return view('books_layout.booklist_pdf', ['books' => $book, 'courses' => $courses, 'subjects' => $subjects, 'keywords' => $keywords]);
                }
                    }
                    
    }      
      
        //     return view('books_layout.booklist_pdf', ['books' => $book, 'courses' => $courses, 'subjects' => $subjects, 'keywords' => $keywords]);

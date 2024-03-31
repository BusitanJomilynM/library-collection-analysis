<?php

use App\Models\TagSuggestion;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TrequestController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/login', function () {
    return view('auth/login');
});



Auth::routes();

Route::middleware(['preventBackHistory'])->group(function () {

Route::get('/', function () {
    return view('auth/login');
});

//Shared routes for Technical Librarian and Department Representative
Route::group(['auth', ['user-access:technician librarian|department representative|teacher']], function () {
    Route::resource('/requisitions', RequisitionController::class);
    Route::get('/requisitions/requisitionEdit/{id}', [RequisitionController::class, 'requisitionEdit'])->name('requisitionEdit');
});

//Shared routes for all users
Route::group(['auth', ['user-access:technician librarian|department representative|staff librarian|teacher']], function () {
    Route::resource('/books', BookController::class);
    Route::post('/books/filter', [BookController::class, 'filter']);
    Route::resource('/tags', TagController::class);
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    // Route::get('/pdf_viewbooks', [BookController::class, 'createPDFBook'])->name('createPDFBook');
    Route::get('/users/editAccount/{id}', [UserController::class, 'editAccount'])->name('editAccount');
    Route::get('/users/changePassword/{id}', [UserController::class, 'changePassword'])->name('changePassword');
    Route::get('/users/updatePassword/{id}', [UserController::class, 'updatePassword'])->name('updatePassword');
    Route::resource('/users', UserController::class);
});

//Shared routes for Technical and Staff Librarian
Route::group(['auth', ['user-access:technician librarian|staff librarian']], function () {

    //books
    Route::get('/book/archive/{book}', [BookController::class, 'archiveBook'])->name('archiveBook');
    Route::get('/book/restore/{book}', [BookController::class, 'restoreBook'])->name('restoreBook');
    Route::get('/book/restoreUpdate/{book}', [BookController::class, 'restoreUpdate'])->name('restoreUpdate');
    Route::get('/book/archiveUpdate/{book}', [BookController::class, 'archiveUpdate'])->name('archiveUpdate');
    Route::get('/archives', [BookController::class, 'archive'])->name('archive');
    Route::get('/books/view_bookdetails/{book}', [BookController::class, 'view_bookdetails'])->name('books.view_bookdetails');
    Route::get('/books/book_createcopy/{book}', [BookController::class, 'book_createcopy'])->name('books.book_createcopy');

    //requisitions
    Route::post('/requisitions/pendingRequisitions', [RequisitionController::class, 'pendingRequisitions'])->name('pendingRequisitions');
    Route::match(['get', 'post'],'/pending', [RequisitionController::class, 'pendingRequisitions'])->name('pendingRequisitions');
    Route::post('/requisition/acceptStatus/{requisition}', [RequisitionController::class, 'changeStatus'])->name('changeStatus');
    Route::match(['get', 'post'], '/requisition/declineStatus/{requisition}', [RequisitionController::class, 'changeStatus2'])->name('changeStatus2');
    Route::get('/requisitions/{requisition}', 'RequisitionController@show')->name('requisitions.show');

    //tags
    Route::get('/tags/pendingTags', [TagController::class, 'pendingTags'])->name('pendingTags');
    Route::get('/pendingt', [TagController::class, 'pendingTags'])->name('pendingTags');
    Route::get('/tag/accept/{tag}', [TagController::class, 'accept'])->name('accept');
    Route::get('/tag/decline/{tag}', [TagController::class, 'decline'])->name('decline');
    Route::get('/tag/update/{tag}', [TagController::class, 'updateTags'])->name('updateTags');
    Route::post('/append/{tag}/{book}', [TagController::class, 'append'])->name('append');
    Route::post('/replace/{tag}/{book}',  [TagController::class, 'replace'])->name('replace');
    
    //booklist reports
    Route::get('/generate-booklist', [BookController::class, 'booklistPdf'])->name('booklist_pdf');
    Route::get('/pdf_view', [BookController::class, 'booklistPdf'])->name('pdf_view');

    // collectionAnalysis reports
    Route::get('/generate-collectionanalysis', [BookController::class, 'collectionAnalysis'])->name('booklis_pdf');
    Route::get('/pdf_collection', [BookController::class, 'collectionAnalysis'])->name('pdf_collection');
    
    //user controls
    Route::get('/users/userEdit/{user}', [UserController::class, 'userEdit'])->name('userEdit');
    Route::get('/users/restorePassword/{user}', [UserController::class, 'restorePassword'])->name('restorePassword');

    //keywords
    Route::resource('/keywords', KeywordController::class);
    Route::get('/keywords/delete/{keyword}', [KeywordController::class, 'destroy'])->name('keywords.destroy');
    Route::get('/keywords/update/{keyword}', [KeywordController::class, 'update'])->name('keywords.update');
    
    // Route::get('/process_form', [BookController::class, 'processForm'])->name('process_form');
// Route::get('/process_form', 'BookController@processForm')->name('process_form');

    
});

//technical lib
Route::middleware(['auth', 'user-access:technician librarian'])->group(function () {
    Route::get('/technician/home', [HomeController::class, 'technicianHome'])->name('technician.home');
    Route::get('books/edit/{book}', [BookController::class, 'edit'])->name('books.edit');
    
    // Route::get('/books/view_bookdetails/{book}', [BookController::class, 'view_bookdetails'])->name('books.view_bookdetails');
    // Route::get('/books/book_createcopy/{book}', [BookController::class, 'book_createcopy'])->name('books.book_createcopy');
    
    // Route::get('/users/userEdit/{user}', [UserController::class, 'userEdit'])->name('userEdit');
    // Route::get('/users/restorePassword/{user}', [UserController::class, 'restorePassword'])->name('restorePassword');

    Route::post('/deleteUser/{user}', [UserController::class, 'confirmDestroy'])->name('confirmDestroy');
    
});

//staff lib
Route::middleware(['auth', 'user-access:staff librarian'])->group(function () {
    Route::get('/staff/home', [HomeController::class, 'staffHome'])->name('staff.home');
});


//dept rep
Route::middleware(['auth', 'user-access:department representative'])->group(function () {
    Route::get('/representative/home', [HomeController::class, 'representativeHome'])->name('representative.home');
    // Route::get('/tags/pendingTags', [TagController::class, 'pendingTags'])->name('pendingTags');

});

//teacher
Route::middleware(['auth', 'user-access:teacher'])->group(function () {
    Route::get('/teacher/home', [HomeController::class, 'teacherHome'])->name('teacher.home');

    //course
    Route::resource('/courses', CourseController::class);
    Route::get('/courses/delete/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::get('/courses/update/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::get('courses/edit/{course}', [CourseController::class, 'edit'])->name('courses.edit');

    //subjects
    Route::resource('/subjects', SubjectController::class);
    Route::get('/subjects/delete/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    Route::get('/subjects/update/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::get('subjects/edit/{subject}', [SubjectController::class, 'edit'])->name('subjects.edit');
   

});

});

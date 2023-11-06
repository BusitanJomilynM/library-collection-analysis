<?php

use App\Models\TagSuggestion;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequisitionController;
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

Route::get('/', function () {
    return view('auth/login');
});


Auth::routes();

Route::group(['auth', ['user-access:technician librarian|department representative']], function () {
    Route::resource('/requisitions', RequisitionController::class);
    Route::get('/requisitions/requisitionEdit/{id}', [RequisitionController::class, 'requisitionEdit'])->name('requisitionEdit');
});

Route::group(['auth', ['user-access:technician librarian|department representative|staff librarian']], function () {
    Route::resource('/books', BookController::class);
    Route::resource('/tags', TagController::class);
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    // Route::get('/pdf_viewbooks', [BookController::class, 'createPDFBook'])->name('createPDFBook');


});

Route::group(['auth', ['user-access:technician librarian|staff librarian']], function () {
    Route::get('/book/arcchive/{book}', [BookController::class, 'archiveBook'])->name('archiveBook');
    Route::get('/book/restore/{book}', [BookController::class, 'restoreBook'])->name('restoreBook');
    Route::get('/book/restoreUpdate/{book}', [BookController::class, 'restoreUpdate'])->name('restoreUpdate');
    Route::get('/archives', [BookController::class, 'archive'])->name('archive');

    Route::get('/requisitions/pendingRequisitions', [RequisitionController::class, 'pendingRequisitions'])->name('pendingRequisitions');
    Route::get('/pending', [RequisitionController::class, 'pendingRequisitions'])->name('pendingRequisitions');
    Route::get('/requisition/acceptStatus/{requisition}', [RequisitionController::class, 'changeStatus'])->name('changeStatus');
    Route::get('/requisition/declineStatus/{requisition}', [RequisitionController::class, 'changeStatus2'])->name('changeStatus2');

    Route::get('/tags/pendingTags', [TagController::class, 'pendingTags'])->name('pendingTags');
    Route::get('/pendingt', [TagController::class, 'pendingTags'])->name('pendingTags');
    Route::get('/tag/accept/{tag}', [TagController::class, 'accept'])->name('accept');
    Route::get('/tag/decline/{tag}', [TagController::class, 'decline'])->name('decline');

    Route::get('/tag/update/{tag}', [TagController::class, 'updateTags'])->name('updateTags');



    
    Route::get('/booklist_pdf', [BookController::class, 'booklistPdf'])->name('booklist_pdf');
    Route::match(['get', 'post'], '/generatePdf', [BookController::class, 'generatePDF'])->name('generatePdf');    

});

Route::middleware(['auth', 'user-access:technician librarian'])->group(function () {
    Route::get('/technician/home', [HomeController::class, 'technicianHome'])->name('technician.home');
    Route::get('books/edit/{book}', [BookController::class, 'edit'])->name('books.edit');
    
    Route::get('/books/view_bookdetails/{book}', [BookController::class, 'view_bookdetails'])->name('books.view_bookdetails');
    Route::get('/books/book_createcopy/{book}', [BookController::class, 'book_createcopy'])->name('books.book_createcopy');
    
    Route::resource('/users', UserController::class);
    Route::get('/users/userEdit/{user}', [UserController::class, 'userEdit'])->name('userEdit');
    
});

Route::middleware(['auth', 'user-access:staff librarian'])->group(function () {
    Route::get('/staff/home', [HomeController::class, 'staffHome'])->name('staff.home');
});

Route::middleware(['auth', 'user-access:department representative'])->group(function () {
    Route::get('/representative/home', [HomeController::class, 'representativeHome'])->name('representative.home');
    // Route::get('/tags/pendingTags', [TagController::class, 'pendingTags'])->name('pendingTags');

});


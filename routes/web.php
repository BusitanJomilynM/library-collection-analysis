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
    Route::resource('requisitions', RequisitionController::class);
    Route::get('requisitions/requisitionEdit/{id}', [RequisitionController::class, 'requisitionEdit'])->name('requisitionEdit');
});

Route::group(['auth', ['user-access:technician librarian|department representative|staff librarian']], function () {
    Route::resource('books', BookController::class);
    Route::resource('tags', TagController::class);
    Route::get('/pdf_viewbooks', [BookController::class, 'createPDFBook'])->name('createPDFBook');
    Route::get('tags', [TagController::class, 'index'])->name('tags.index');
});

Route::middleware(['auth', 'user-access:technician librarian'])->group(function () {
    Route::get('/technician/home', [HomeController::class, 'technicianHome'])->name('technician.home');
    Route::get('books/edit/{book}', [BookController::class, 'edit'])->name('books.edit');
    Route::resource('users', UserController::class);
    Route::get('requisitions/pendingRequisitions', [TagController::class, 'pendingRequisitions'])->name('pendingRequisitions');
    Route::get('users/userEdit/{user}', [UserController::class, 'userEdit'])->name('userEdit');
    Route::get('requisition/acceptStatus/{requisition}', [RequisitionController::class, 'changeStatus'])->name('changeStatus');
    Route::get('requisition/declineStatus/{requisition}', [RequisitionController::class, 'changeStatus2'])->name('changeStatus2');
    Route::get('/pending', [RequisitionController::class, 'pendingRequisitions'])->name('pendingRequisitions');
});

Route::middleware(['auth', 'user-access:staff librarian'])->group(function () {
    Route::get('/staff/home', [HomeController::class, 'staffHome'])->name('staff.home');
});

Route::middleware(['auth', 'user-access:department representative'])->group(function () {
    Route::get('/representative/home', [HomeController::class, 'representativeHome'])->name('representative.home');
    Route::get('/pendingTags', [TagController::class, 'pendingTags'])->name('pendingTags');
    Route::get('tag/accept/{tag}', [TagController::class, 'accept'])->name('accept');
    Route::get('tag/decline/{tag}', [TagController::class, 'decline'])->name('decline');
});


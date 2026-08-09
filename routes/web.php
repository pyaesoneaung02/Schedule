<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// Directory Connection
require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/user.php';
require __DIR__ . '/auth.php';


// Route::get('/', function () {
//     return view('welcome');
// });
// Route::redirect('/', '/login');

Route::get('/', [UserController::class, 'landingPage'])->name('landingPage');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//google login && github login

//auth
Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('socialLogin');

Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('socialCallback');


//landing page
// Route::get('/landingPage', [UserController::class, 'landingPage'])->name('landingPage');

//show subjects by year
Route::get('/subjects/year/{id}',[UserController::class, 'filterByYear'])->name('subject.filter.year');

//detail subject page
Route::get('/subject/detail/{id}',[UserController::class, 'subjectDetail'])->name('subject.detail');

//delete subject
Route::delete('/subjects/{id}', [UserController::class, 'delete'])->name('subject.delete');

//about page
Route::get('/about', [UserController::class, 'about'])->name('about');




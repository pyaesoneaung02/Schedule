<?php
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user', 'middleware' => 'user'], function () {

    // homepage route
    Route::get('home', [UserController::class, 'userHome'])->name('userHome');

    // Schedule
    // Route::get('schedule', function () {
    //     return view('user.schedule');
    // })->name('user.schedule');
    Route::get('schedule', [UserController::class, 'schedulePage'])->name('user.schedule');

    // Subject
    // Route::get('subject', function () {
    //     return view('user.subject');
    // })->name('user.subject');
    Route::get('subject', [UserController::class, 'subjectPage'])->name('user.subject');

    // Contact
    // Route::get('contact', function () {
    //     return view('user.contact');
    // })->name('user.contact');
    Route::get('contact', [UserController::class, 'contactPage'])->name('user.contact');

    // Subject
    // Route::get('subject', [UserController::class, 'subjectPage'])->name('user.subject');

    // Contact store
    Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');

    //contact read
    Route::get('/contact/read/{id}',[ContactController::class, 'read'])->name('contact.read');

    // Profile Routes
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');

    // Password Routes
    Route::get('password/change', [UserController::class, 'changePasswordPage'])->name('user.password.change');
    Route::post('password/update', [UserController::class, 'updatePassword'])->name('user.password.update');

});

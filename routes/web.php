<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProgressRecordController;
use App\Models\HomeClientStory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::guard('instructor')->check()) {
        return redirect('/instructor');
    } elseif (Auth::guard('client')->check()) {
        return redirect('/client');
    } elseif (Auth::guard('web')->check()) {
        return redirect('/admin');
    } else {
        $stories = HomeClientStory::query()
            ->where('status', '=', 'active')
            ->get();

        return view('homepage')->with('stories', $stories);
    }
});

Route::get('/about', function () {
    return view('about');
});

Route::controller(AdminController::class)->group(function() {
    Route::get('/admin', 'manageAccountsView');
    Route::get('/admin/instructors', 'manageInstructorAccounsView');

    Route::get('/admin/homepage-story', 'homepageStoryView');
    Route::get('/admin/featured-instructors', 'featuredInstructorsView');

    Route::post('/admin/homepage-story/create', 'createHomepageStory');
    Route::get('/admin/homepage-story/{story}/toggle-status', 'toggleHomepageStory');
    Route::delete('/admin/homepage-story/{story}/delete', 'destroyHomepageStory');
    Route::put('/admin/homepage-story/{story}/update', 'updateHomepageStory');

    Route::post('/admin/featured-instructor/create', 'addFeaturedInstructor');
    Route::delete('/admin/featured-instructor/{instructor}/delete', 'removeFeaturedInstructor');

    Route::get('/client/disable/{client}', 'disableClient');
    Route::get('/client/enable/{client}', 'enableClient');

    Route::get('/instructor/disable/{instructor}', 'disableInstructor');
    Route::get('/instructor/enable/{instructor}', 'enableInstructor');
});

Route::controller(ProgressRecordController::class)->group(function() {
    Route::post('/session/store', 'store')->name('progress.store');
});

Route::controller(ClientController::class)->group(function() {
    Route::get('/client', 'profileView');
    Route::get('/client/browse', 'browseView');
    Route::get('/session/schedule/{instructor}', 'scheduleView');

    Route::post('/session/schedule/monthly', 'scheduleMonthly');
    Route::post('/session/schedule/hourly', 'scheduleHourly');
    Route::post('/session/{session}/event/create', 'createEvent');
    Route::delete('/session/event/{event}/delete', 'deleteEvent');
    Route::put('/session/event/{event}/edit', 'updateEvent');

    Route::get('/my/sessions', 'clientSessions');
    Route::post('/session/{session}/notes', 'setNotes');
    Route::post('/session/setstars/{session}', 'setStars');
    Route::post('/session/end/{session}', 'endSession');

    Route::post('/client/updateprofile/{client}', 'updateProfile');
});

Route::controller(InstructorController::class)->group(function () {
    Route::get('/instructor', 'profileView');
    Route::get('/instructor/clients', 'clientsView');

    Route::post('/instructor/updateprice/{instructor}', 'updatePricing');
    Route::post('/instructor/updateprofile/{instructor}', 'updateProfile');
    
    Route::post('/session/start/{session}', 'startSession');
    Route::post('/session/cancel/{session}', 'cancelSession');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'registerView');
    Route::get('/register-client', 'registerClientView');

    Route::post('/register', 'register');
    Route::post('/register-client', 'registerClient');

    Route::get('/login', 'loginView')->middleware('guest');
    Route::post('/login', 'login');

    Route::get('/logout', 'logout');
});

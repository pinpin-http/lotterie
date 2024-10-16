<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//routes general et d'auth

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');


//voir le rankings des differents tirage
Route::get('/ranking', [HomeController::class, 'viewRanking'])->name('ranking');



//routes reservé au groupe admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    //routes pour afficher traiter et lancer un tirage
    Route::get('/admin/create-draw', [AdminController::class, 'createDrawForm'])->name('admin.create_draw');
    Route::post('/admin/store-draw', [AdminController::class, 'storeDraw'])->name('admin.store_draw');
    Route::post('/admin/launch-draw/{draw}', [AdminController::class, 'launchDraw'])->name('admin.launch_draw');
    //partage des prix
    Route::post('/admin/distribute-prizes/{draw}', [AdminController::class, 'distributePrizes'])->name('admin.distribute_prizes');

    //route de cheaters
    Route::post('/admin/generate-fake-participants', [AdminController::class, 'generateFakeParticipants'])->name('admin.generate_fake_participants');
});


//routes reservé au groupe user normal
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/participate', [UserController::class, 'participate'])->name('user.participate');
});



Route::get('/test-middleware', function () {
    return 'Middleware passed!';
})->middleware('role:admin');

Route::get('/test', [App\Http\Controllers\TestController::class, 'index'])->name('test.index');

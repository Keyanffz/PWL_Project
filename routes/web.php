<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\TutorialDetailController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ApiController;

// Public routes (tanpa login)
Route::get('/presentation/{slug}', [PublicController::class, 'presentation'])->name('public.presentation');
Route::get('/finished/{slug}',     [PublicController::class, 'finished'])->name('public.finished');

// API endpoint
Route::get('/api/{kode_matkul}', [ApiController::class, 'tutorialByMatkul']);

// Auth
Route::get('/',        [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// Master Tutorial
Route::get('/tutorials/data',     [TutorialController::class, 'getData'])->name('tutorials.data');
Route::resource('tutorials', TutorialController::class);

// Detail Tutorial
Route::get('/tutorials/{tutorialId}/details/data',
    [TutorialDetailController::class, 'getData'])->name('tutorial-details.data');
Route::get('/tutorials/{tutorialId}/details',
    [TutorialDetailController::class, 'index'])->name('tutorial-details.index');
Route::get('/tutorials/{tutorialId}/details/create',
    [TutorialDetailController::class, 'create'])->name('tutorial-details.create');
Route::post('/tutorials/{tutorialId}/details',
    [TutorialDetailController::class, 'store'])->name('tutorial-details.store');
Route::get('/tutorials/{tutorialId}/details/{id}/edit',
    [TutorialDetailController::class, 'edit'])->name('tutorial-details.edit');
Route::put('/tutorials/{tutorialId}/details/{id}',
    [TutorialDetailController::class, 'update'])->name('tutorial-details.update');
Route::delete('/tutorials/{tutorialId}/details/{id}',
    [TutorialDetailController::class, 'destroy'])->name('tutorial-details.destroy');
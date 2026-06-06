<?php

use App\Http\Controllers\ListingSubmissionController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/story', [WebsiteController::class, 'story'])->name('story');

Route::get('/jobs', [WebsiteController::class, 'jobs'])->name('jobs.index');
Route::get('/jobs/{listing}', [WebsiteController::class, 'showJob'])->name('jobs.show');
Route::post('/jobs/{listing}/apply', [ListingSubmissionController::class, 'store'])->name('jobs.apply');

Route::get('/tenders', [WebsiteController::class, 'tenders'])->name('tenders.index');
Route::get('/tenders/{listing}', [WebsiteController::class, 'showTender'])->name('tenders.show');
Route::post('/tenders/{listing}/apply', [ListingSubmissionController::class, 'store'])->name('tenders.apply');

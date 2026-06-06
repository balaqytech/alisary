<?php

use App\Http\Controllers\ListingSubmissionController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebsiteController::class, 'home'])->name('home');
Route::get('/story', [WebsiteController::class, 'story'])->name('story');

Route::get('/jobs', [WebsiteController::class, 'jobs'])->name('jobs.index');
Route::get('/jobs/{jobListing}', [WebsiteController::class, 'showJob'])->name('jobs.show');
Route::post('/jobs/{jobListing}/apply', [ListingSubmissionController::class, 'storeJob'])->name('jobs.apply');

Route::get('/tenders', [WebsiteController::class, 'tenders'])->name('tenders.index');
Route::get('/tenders/{tenderListing}', [WebsiteController::class, 'showTender'])->name('tenders.show');
Route::post('/tenders/{tenderListing}/apply', [ListingSubmissionController::class, 'storeTender'])->name('tenders.apply');

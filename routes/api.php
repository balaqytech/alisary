<?php

use App\Http\Controllers\Api\JobApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/job-applications', [JobApplicationController::class, 'index']);

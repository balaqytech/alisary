<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;

class JobApplicationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(JobApplication::all());
    }
}

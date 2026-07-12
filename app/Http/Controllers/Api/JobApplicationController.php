<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = JobApplication::with('company');

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->integer('company_id'));
        }

        return response()->json($query->get());
    }
}

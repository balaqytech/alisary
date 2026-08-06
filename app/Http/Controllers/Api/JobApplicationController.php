<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\JobApplicationResource;
use App\Models\JobApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = JobApplication::with([
            'company:id,name',
            'firstPriorityJobListing:id,job_code,title',
            'secondPriorityJobListing:id,job_code,title',
            'thirdPriorityJobListing:id,job_code,title',
        ]);

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->integer('company_id'));
        }

        $applications = $query->get()->map(
            fn (JobApplication $application): array => (new JobApplicationResource($application))->resolve($request)
        );

        return response()->json($applications);
    }
}

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
        $query = JobApplication::with([
            'company',
            'firstPriorityJobListing:id,job_code,title',
            'secondPriorityJobListing:id,job_code,title',
            'thirdPriorityJobListing:id,job_code,title',
        ]);

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->integer('company_id'));
        }

        $applications = $query->get()->map(function (JobApplication $application): array {
            $priorityTitles = [
                'job_priority_1' => $application->firstPriorityJobTitle(),
                'job_priority_2' => $application->secondPriorityJobTitle(),
                'job_priority_3' => $application->thirdPriorityJobTitle(),
            ];

            $application
                ->unsetRelation('firstPriorityJobListing')
                ->unsetRelation('secondPriorityJobListing')
                ->unsetRelation('thirdPriorityJobListing');

            return [
                ...$application->toArray(),
                ...$priorityTitles,
            ];
        });

        return response()->json($applications);
    }
}

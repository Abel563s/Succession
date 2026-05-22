<?php

namespace App\Services;

use App\Models\Development;
use App\Models\ProgressIdpObjective;
use App\Models\ProgressReview;
use Illuminate\Support\Facades\DB;

class DevelopmentProgressWorkflow
{
    public function createLinkedProgressReview(Development $development): ProgressReview
    {
        if ($development->progressReview) {
            return $development->progressReview;
        }

        return DB::transaction(function () use ($development) {
            $development->load('objectives');

            $review = ProgressReview::query()->create([
                'development_id' => $development->id,
                'created_by' => $development->created_by ?? auth()->id(),
                'candidate_name' => $development->employee_name,
                'department' => $development->department,
                'line_manager' => $development->line_manager,
                'performance_summary' => 'Linked to Individual Development Plan #'.$development->id.'. Update scores and tracking below.',
                'status' => 'draft',
                'approval_status' => 'Pending',
                'signature_path' => $development->signature_path,
            ]);

            foreach ($development->objectives as $objective) {
                ProgressIdpObjective::query()->create([
                    'progress_review_id' => $review->id,
                    'idp_objective_id' => $objective->id,
                    'row_number' => $objective->row_number,
                    'objective' => $objective->objective,
                    'activity' => $objective->activity,
                    'resource' => $objective->resource,
                    'start_date' => $objective->start_date,
                    'delivery_date' => $objective->delivery_date,
                    'expected_outcome' => $objective->expected_outcome,
                    'score' => null,
                ]);
            }

            return $review->load('idpObjectives');
        });
    }
}

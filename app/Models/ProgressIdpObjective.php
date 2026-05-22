<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressIdpObjective extends Model
{
    protected $fillable = [
        'progress_review_id',
        'idp_objective_id',
        'row_number',
        'objective',
        'activity',
        'resource',
        'start_date',
        'delivery_date',
        'expected_outcome',
        'score',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'delivery_date' => 'date',
        ];
    }

    public function progressReview(): BelongsTo
    {
        return $this->belongsTo(ProgressReview::class);
    }

    public function idpObjective(): BelongsTo
    {
        return $this->belongsTo(IdpObjective::class);
    }
}

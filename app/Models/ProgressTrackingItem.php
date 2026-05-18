<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressTrackingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'progress_review_id',
        'review_date',
        'achievements',
        'challenges',
        'next_steps',
    ];

    public function progressReview()
    {
        return $this->belongsTo(ProgressReview::class);
    }
}

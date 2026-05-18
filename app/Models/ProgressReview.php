<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'department',
        'line_manager',
        'performance_summary',
        'new_competencies',
        'gaps_identified',
        'updated_action_plan',
        'signature_path',
        'status',
    ];

    public function trackingItems()
    {
        return $this->hasMany(ProgressTrackingItem::class);
    }
}

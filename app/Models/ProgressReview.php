<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgressReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'development_id',
        'created_by',
        'candidate_name',
        'department',
        'line_manager',
        'performance_summary',
        'new_competencies',
        'gaps_identified',
        'updated_action_plan',
        'signature_path',
        'status',
        'approval_status',
    ];

    public function trackingItems(): HasMany
    {
        return $this->hasMany(ProgressTrackingItem::class);
    }

    public function idpObjectives(): HasMany
    {
        return $this->hasMany(ProgressIdpObjective::class);
    }

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

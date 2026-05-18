<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadershipCompetencyRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'leadership_assessment_id',
        'competency_name',
        'rating',
    ];

    public function leadershipAssessment()
    {
        return $this->belongsTo(LeadershipAssessment::class);
    }
}

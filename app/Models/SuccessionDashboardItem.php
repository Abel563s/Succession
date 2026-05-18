<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessionDashboardItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'succession_dashboard_id',
        'position',
        'current_holder',
        'candidates',
        'timeline_progress',
        'competency_progress',
        'development_progress',
        'kpi_metrics',
        'monitoring_progress',
        'readiness_rating',
    ];

    public function successionDashboard()
    {
        return $this->belongsTo(SuccessionDashboard::class);
    }
}

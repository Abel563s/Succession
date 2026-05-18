<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name',
        'department',
        'critical_role',
        'position_status',
        'vacancy_risk',
        'position_impact',
        'successor_1_name',
        'successor_1_readiness',
        'successor_2_name',
        'successor_2_readiness',
        'successor_3_name',
        'successor_3_readiness',
        'mitigation_plan',
        'signature_path',
    ];
}

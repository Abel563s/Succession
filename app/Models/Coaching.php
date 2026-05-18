<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coaching extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_name',
        'supervisor',
        'department',
        'coaching_date',
        'topic_1',
        'topic_2',
        'topic_3',
        'desired_outcome',
        'benefits',
        'action_plan',
        'supervisor_support',
        'timeline',
        'manager_signature',
        'candidate_signature',
    ];
}

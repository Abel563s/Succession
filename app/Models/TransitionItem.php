<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransitionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transition_id',
        'row_number',
        'critical_role',
        'current_holder',
        'successor',
        'transition_date'
    ];

    public function transition()
    {
        return $this->belongsTo(Transition::class);
    }
}

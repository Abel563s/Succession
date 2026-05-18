<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdpObjective extends Model
{
    use HasFactory;

    protected $fillable = [
        'development_id',
        'row_number',
        'objective',
        'activity',
        'resource',
        'start_date',
        'delivery_date',
        'expected_outcome',
        'score',
    ];

    public function development()
    {
        return $this->belongsTo(Development::class);
    }
}

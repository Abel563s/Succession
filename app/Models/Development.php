<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Development extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name',
        'department',
        'line_manager',
        'signature_path',
    ];

    public function objectives()
    {
        return $this->hasMany(IdpObjective::class);
    }
}

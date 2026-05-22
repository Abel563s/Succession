<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Development extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name',
        'department',
        'line_manager',
        'signature_path',
        'candidate_signature_path',
        'approval_status',
        'created_by',
    ];

    public function objectives(): HasMany
    {
        return $this->hasMany(IdpObjective::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function progressReview(): HasOne
    {
        return $this->hasOne(ProgressReview::class);
    }
}

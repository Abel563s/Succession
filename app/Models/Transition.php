<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    use HasFactory;

    protected $fillable = [
        'department',
        'status',
        'signature_path',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(TransitionItem::class)->orderBy('row_number');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

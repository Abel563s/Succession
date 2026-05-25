<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessionDashboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department',
        'signature_path',
        'status',
        'approval_status',
        'created_by',
    ];

    public function items()
    {
        return $this->hasMany(SuccessionDashboardItem::class);
    }
}

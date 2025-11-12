<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'target_amount',
        'current_amount',
        'target_date',
        'status'
    ];

    protected $casts = [
        'target_date' => 'date',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'sub_group_id',
        'date',
        'wallet_id',
    ];

    public function subGroup()
    {
        return $this->belongsTo(SubGroup::class);
    }
}

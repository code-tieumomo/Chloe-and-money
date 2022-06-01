<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingMoney extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'user_id'];
}
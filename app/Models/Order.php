<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'user_is',
        'work_id',
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}

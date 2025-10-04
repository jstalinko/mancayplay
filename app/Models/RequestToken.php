<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestToken extends Model
{
    use HasFactory;
   
            protected $fillable = [
                'user_id',
                'status',
                'token',
                'type',
            ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }
}

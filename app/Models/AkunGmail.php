<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunGmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'app_password',
        'imap_server',
        'imap_port'
    ];
}

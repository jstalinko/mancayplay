<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'active',
        'link',
        'category',
        'price',
        'short_description',
        'product_type',
        'remove_product_after_sale',
        'product_content',
        'otp_feature',
        'akun_gmail_id',
        'get_only_subject'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
 

            protected $fillable = [
                'invoice',
                'reference',
                'product_id',
                'order_type',
                'customer_name',
                'customer_email',
                'customer_phone',
                'price',
                'status',
                'payment_proof',
                'notes',
                'product_content'
            ] ;

            public function product()
            {
                return $this->belongsTo(Product::class);
            }
}

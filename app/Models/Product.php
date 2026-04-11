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

    public function removeProductContentFirstLine()
    {
        $this->product_content = substr($this->product_content, strpos($this->product_content, "\n") + 1);
        $this->save();
    }

    public function getProductContentFirstLine()
    {
        return substr($this->product_content, 0, strpos($this->product_content, "\n"));
    }

    public function getProductContent()
    {
        if($this->product_type == 'text' && $this->remove_product_after_sale) {
            $content = $this->getProductContentFirstLine();
            $this->removeProductContentFirstLine();
            return $content;
        } else if($this->product_type == 'text'){
            return $this->product_content;
        }else{
            return url('storage/'.$this->product_content);
        }
    }
}

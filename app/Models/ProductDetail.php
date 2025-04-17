<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $table = 'product_details';

    protected $fillable = [
        'product_id',
        'qty',
        'combo_product',
        'title_product',
        'is_active'
    ];

    public function productdetail()
    {
        return $this->belongsTo(Product::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    
}

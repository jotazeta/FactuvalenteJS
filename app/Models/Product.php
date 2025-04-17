<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'image', 
        'barcode', 
        'title',    
        'description', 
        'buy_price', 
        'sell_price', 
        'category_id', 
        'stock',
        'impuesto',
        'tipo',
        'precio_base',
        'minimo',
        'maximo',
        'activo',
        'venta_negativo',
        'codigo_unspsc',
        'unit',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/uploads/products/'. $value),
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Codigo extends Model
{
    use HasFactory;

    protected $table = 'codigo';

    protected $fillable = [
        'codigo',
        'name',
        'description',
        'is_active'
        
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

   
}

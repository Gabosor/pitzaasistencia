<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo',
        'precio',
        'producto_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
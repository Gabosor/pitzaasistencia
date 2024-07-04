<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'pedido_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productTypes()
    {
        return $this->hasMany(ProductType::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}

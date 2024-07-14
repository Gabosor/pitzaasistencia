<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
     protected $fillable = [
        'nombre',
        'precio',
        'imagen',
        'disponible',
        'categoria_id',
    ];
    public function setImagenAttribute($value)
    {
        $this->attributes['imagen'] = pathinfo($value, PATHINFO_BASENAME);
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}

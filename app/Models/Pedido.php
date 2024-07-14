<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'total',
        'estado',
        'client_id'
    ];
    
    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedido_productos')->withPivot('cantidad');
    }
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

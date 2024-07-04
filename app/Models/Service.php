<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'observacion',
        'pagoSer',
        'companie_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

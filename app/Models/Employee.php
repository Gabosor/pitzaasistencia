<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'ci',
        'nombres',
        'apellidos',
        'usuarios',
        'clave',
        'fechaIng',
        'rol',
        'SalarioBase',
        'telefono',
        'email'
    ];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}

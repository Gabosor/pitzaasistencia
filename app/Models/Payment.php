<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
     protected $fillable = [
        'fecRealizado',
        'total',
        'client_id',
        'employee_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function personal()
    {
        return $this->belongsTo(Employee::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
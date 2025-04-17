<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'amount',
        'payed_at',
        'oder_id',
    ];

    //Esto es para trabajar con Carbon php. estos son los atributos que deben ser mutados a dates
    protected $dates = [
        'payed_at',
     ];

     //este metodo define que el payment pertenece a el order. retorna el id del order
     public function order(){
        return $this->belongsTo(Order::class);
     }
}

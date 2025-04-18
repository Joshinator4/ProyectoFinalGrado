<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    //Esta funcion trae los datos de la tabla pivote de cart-products. Hay que usar belong to many xq es relacion muchos a muchos.
    public function products(){
        // return $this->belongsToMany(Product::class)->withPivot('quantity');//!Relacion muchos a muchos simple
        return $this->morphToMany(Product::class, 'productable')->withPivot('quantity');//!Se usa withPivot para traer la columna quantity, si no solo traería los id respectivos.
        //!OJO la orden tiene productos por eso morphToMany
    }

    //Este método genera un nuevo atributo llamado total en el cart. Accede al atributo total de cada product y los suma devolviendo el precio total del cart
    public function getTotalAttribute(){
        //!pluck() devuelve una lista de todos los value de una key dada.
        //!aqui desde el carro se recorre a todos los productos por medio de pluck y se accede al atributo total ('creado' con getTotalAttribute) y sumarlos todos para dar el precio total del carrito
        return $this->products->pluck('total')->sum();
     }
}

<?php

namespace App\Models;

use App\Models\Scopes\AvailableScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'customer_id',
    ];

    //Esta funcion es para la relacion 1 a 1 de las 2 tablas. retorna el id del pago
    public function payment(){
        return $this->hasOne(Payment::class);
    }

    //esta funcion es para la relacion 1 a muchos. 1 user tiene muchas orders
    public function user(){
        return $this->belongsTo(User::class, 'customer_id');//!El segundo parámetro es para indicarle el nombre de la columna. Laravel piensa que se llama user_id (ya que viene de la tabla users) hay que hacerlo en user y en order
    }

    //Esta funcion trae los datos de la tabla pivote de order-products. Hay que usar belong to many xq es relacion muchos a muchos.
    public function products(){
        // return $this->belongsToMany(Product::class)->withPivot('quantity');//!Relacion muchos a muchos simple
        return $this->morphToMany(Product::class, 'productable')->withPivot('quantity');//!Se usa withPivot para traer la columna quantity, si no solo traería los id respectivos.
        //!OJO la orden tiene productos por eso morphToMany
    }

    //Este método genera un nuevo atributo llamado total en el cart. Accede al atributo total de cada product y los suma devolviendo el precio total del cart
    public function getTotalAttribute(){
        //!pluck() devuelve una lista de todos los value de una key dada.
        //!aqui desde el carro se recorre a todos los productos por medio de pluck y se accede al atributo total ('creado' con getTotalAttribute) y sumarlos todos para dar el precio total del carrito
        return $this->products()
        ->withoutGlobalScope(AvailableScope::class)//*para que al momento de hacer el pago los productos que se queden con stock 0 no desaparezcan del total, se debe ignorar el scope de AvailableScope para que así aunque esté unavailable (cambiado por el evento updated de Product), pueda hacer los metodos a continuacion pluck y sum correctamente
        ->get()//se usa el get para poder obtener los datos de la BBDD
        ->pluck('total')
        ->sum();
     }

     public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }


}

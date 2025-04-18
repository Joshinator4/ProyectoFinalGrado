<?php

namespace App\Models;

//los modelos es donde se definen las clases

//Este modelo se ha creado con php artisan make:model Product

use App\Models\Scopes\AvailableScope;

use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//!ASI SE AÑADEN SCOPES AL MODELO. En este caso solo cogera en cada query que se haga a la BBDD solo los productos que tengas status = available
#[ScopedBy([AvailableScope::class])]
class Product extends Model
{
    use HasFactory, SoftDeletes;//*soft delete es una forma que tiene eloquent para que no elimine este caso el producto, solo lo oculta.

    protected $table = 'products';//!Esta es una forma de indicar a laravel de forma explicita que su tabla en la BBDD es la que se llama products y por ende todas las clases que heren de esta, su tabla tambien será products

    //!Este es un eager, se le indica que en las consultas a las BBDD que se hagan de productos se traigan siempre estas relaciones (en este caso solo las imagenes)
    protected $with = [
        'images',
    ];

    //se usa hasfactory para crear valores aleatorios
    //Se crea vacio y se añade el fillable que se usa para asignar atributos de manera masiva
    protected $fillable = [
        'title',
        'description',
        'price',
        'stock',
        'status',
    ];


    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        //!Tambien se puede añadir el global scope de esta forma
        // static::addGlobalScope(new AvailableScope);

        //*Se le añade un scope, llamando al evento updated de esta forma
        static::updated(function (Product $product) {//!Cuidado aqui si no se pone la segunda condicion se haria un bucle infinito
            if($product->stock == 0 && $product->status == 'available') {
                $product->status = 'unavailabe';
                $product->save();
            }
        });
    }


    //Esta funcion trae los datos de la tabla pivote de carts-products. Hay que usar belong to many xq es relacion muchos a muchos.
    public function carts(){
        // return $this->belongsToMany(Cart::class)->withPivot('quantity');//!Relacion muchos a muchos simple
        return $this->morphedByMany(Cart::class, 'productable')->withPivot('quantity');//!Se usa withPivot para traer la columna quantity, si no solo traería los id respectivos. Relacion muchos a muchos polimórfica
        //!OJO el producto pertenece a muchos cart por eso morphedByMany
    }

    //Esta funcion trae los datos de la tabla pivote de order-products. Hay que usar belong to many xq es relacion muchos a muchos.
    public function orders(){
        // return $this->belongsToMany(Order::class)->withPivot('quantity');//!Relacion muchos a muchos simple
        return $this->morphedByMany(Order::class, 'productable')->withPivot('quantity');//!Se usa withPivot para traer la columna quantity, si no solo traería los id respectivos. Relacion muchos a muchos polimórfica
        //!OJO el producto pertenece a muchas order por eso morphedByMany
    }

    //esta funcion define la relacion polimórfica uno a muchos con image (1producto muchas image). Imagen puede ser de producto o de usuario
     public function images(){
        return $this->morphMany(Image::class,'imageable');//!1er argumento la clase imagen. 2º argumento el nombre de la columna de la relacion polimórfica
     }

     //!esto es un scope se llama siempre con scopeNombreDelScope y se le pasa $query como parámetro
     public function scopeAvailable($query){
        $query->where('status', 'available');
     }

     //!Este metodo genera un nuevo atributo llamado total en cada product que contará la cantidad de products en el cart u order y los multiplicará por su precio
     public function getTotalAttribute(){
        //se accede a la cantidad a través de la tabla pivote
        $qty = $this->pivot->quantity ?? 0;
        return $qty * $this->price;
     }

     public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

}

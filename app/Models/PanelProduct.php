<?php
//!Se ha creado este modelo para que los usuarios admin puedan editar, mostrar y eleminar los productos que estan como status = unavailable, simplemente se herea de producto y se cambia el metodo booted para indicar que ignore el global scope AvailableScope
namespace App\Models;

use App\Models\Product;
use App\Models\Scopes\AvailableScope;

class PanelProduct extends Product
{

    // protected $table = 'products';//!Esta es una forma de indicar a laravel que su tabla en la BBDD es la que se llama products y no panel_products
    protected static function booted(): void
    {
        static::withoutGlobalScope(AvailableScope::class);//!Se hace asi por el uso del #ScopedBy del modelo Product, se indica que ahora se ignnorará el global scope
        // static::addGlobalScope(new AvailableScope); Asi se haria si se ha usado el metodo booted en el modelo Product, pero se ha usado e #ScopedBy
    }

    //!Este metodo devolverá la clave foránea del product padre. para poder recibir las imagenes y etc...
    public function getForeignKey(){
        $parent = get_parent_class($this);//*A la variable parent se le asigna la clase padre product

        return (new $parent)->getForeignKey();//Estamos obligados a crear una estancia del padre para poder trabajar con el y recibimos la clave foránea
    }
     //!Este metodo devolverá la clave foránea del product para las relaciones polimóficas
    public function getMorphClass(){
        $parent = get_parent_class($this);//*A la variable parent se le asigna la clase padre product

        return (new $parent)->getMorphClass();//Estamos obligados a crear una estancia del padre para poder trabajar con el
    }
}

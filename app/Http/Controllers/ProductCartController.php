<?php

//!este metodo se ha generado asi: php artisan make:controller ProductCartController -m Cart -p Product
//! -m se refier a que el modelo es Cart y el padre es Product
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use \Illuminate\Validation\ValidationException;

class ProductCartController extends Controller

{
    //!ESTO es inyeccion de dependencias. Se crea una variable local y se le asigna un servicio
    //!En este caso se le inyecta el servicio de cartService que tiene el metodo getFromCookieOrCreate()
    public $cartService;

    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }

    public function store(Request $request, Product $product)
    {
        $cart = $this->cartService->getFromCookieOrCreate();//se filtra si existe ya el carrito o no con la funcion creada en el servicio

        // $cart = Cart::create();//creamos el carro

        $quantity = $cart->products()//!se busca la cantidad del producto añadido al carro (por si ya se ha añadido una cantidad)
                        ->find($product->id)//se hace la busqueda por el id del producto recibido por parámetro
                        ->pivot//el atributo pivot contiene las claves foráneas y la cantidad en este caso
                        ->quantity ?? 0;//se crea condicional, si no existe se pone a 0, si no se pone la cantidad recibida por quantity

        //!Este condicional se crea cerciorarnos que la cantidad solicitada para añadir al carrito no supera el stock actual del producto. OJO si no habia quantity del produto en el cart, quantity será 0, pero no es correcto porque ya se ha añadido 1 por eso se suma 1 a quantity
        if($product->stock < $quantity +1){
            //?Si no hay mas quantity solicitada que el stock, lanzará una excecpción de validacion
            throw ValidationException::withMessages([
                'product'=> "There is not enough stock for the quantity you required of {$product->title}"
            ]);
        }

        $cart->products()->syncWithoutDetaching([$product->id => ['quantity' => $quantity +1],]);//sync verifica si ya existe ese producto en el carrito y suma 1 en el contador, pero solo se queda con el último añadido. syncWithoutDetaching hace las 2 funciones añade a los ya existentes y si se marca otro diferencte tambien lo guarda

        $cart->touch();//*este metodo lo que hace es actualizar el carrito, para actualizar su fecha de eliminacion etc, para que un carrito que no ha sido abandonado, no se siga tratando como tal. Al agregar cualquier producto se actualizará

        $cookie = $this->cartService->makeCookie($cart);

        return redirect()->back()->cookie($cookie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Cart $cart)
    {
        $cart->products()->detach($product->id);//se elimina el producto

        $cookie = $this->cartService->makeCookie($cart);

        return redirect()->back()->cookie($cookie);

    }


}

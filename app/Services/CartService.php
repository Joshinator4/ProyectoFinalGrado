<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

class CartService{

    //?ESTO es para usar los nombre etc crados en el archivo de configuracion cart
    protected $cookieName;
    protected $cookieExpiration;

    public function __construct(){
        $this->cookieName = config('cart.cookie.name');
        $this->cookieExpiration =  config('cart.cookie.expiration');
    }

    //Este metodo si existe ya la cookie cart se queda con el cart y lo devuelve, si no existe devuelve null.
    public function getFromCookie(){
        $cartId = Cookie::get($this->cookieName);//con cookie()->get('cart')tmb se busca una cookie que se llame asi

        $cart = Cart::find($cartId);//se busca si existe o no el cart con el cartId generado por a cookie

        return $cart;

    }

    //Este metodo si existe ya la cookie cart se queda con el cart, si no existe la cookie se crea el cart. Para que no se cree el carro siempre se crea getFromCookie para llamar a getFromCookieOrCreate() donde nos interese
    public function getFromCookieOrCreate(){

        $cart = $this->getFromCookie();

        return $cart ?? Cart::create();//se retorna el cart ya existente o si no existe se crea uno y se devuelve
    }

    public function makeCookie(Cart $cart){

        return Cookie::make($this->cookieName, $cart->id, $this->cookieExpiration);//se crea la cookie de nuevo, se le pasa el id del cart creado para que la cookie este "actualizada con la nueva cantidad" y el tiempo que queramos(este caso 1 semana)
    }

    //Este metodo contará la cantidad de productos que hay en el carrito
    public function countProducts(){

        $cart = $this->getFromCookie();

        if($cart != null){
            return $cart->products->pluck('pivot.quantity')->sum();//pluck busca en el elemento por el nombre de un atributo y sum las suma las cantidades obtenidas
        }

        return 0;
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Services\CartService;

class CartController extends Controller
{
    //!ESTO es inyeccion de dependencias. Se crea una variable local y se le asigna un servicio
    //!En este caso se le inyecta el servicio de cartService que tiene el metodo getFromCookieOrCreate()
    public $cartService;

    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('carts.index')->with([
                                            'cart' => $this->cartService->getFromCookie(),//!Se llama al servicio y se le pasa el carro creado o ya existente. Pero de esta forma puede devolver null y hay que modificar la vista de carts.index
                                        ]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;

class CartItemManager extends Component
{
    public Product $product;
    public int $quantity = 0;
    public float $total;

    public function mount(Product $product)
    {
        $this->product = $product;
        $cart = app(CartService::class)->getFromCookieOrCreate();
        $this->quantity = $cart->products()->find($this->product->id)?->pivot?->quantity ?? 0;
        $this->total = $this->product->total ?? ($product->price * $this->quantity);
    }

    public function add()
    {
        $cart = app(CartService::class)->getFromCookieOrCreate();

        if ($this->product->stock <= $this->quantity) {
            $this->dispatch('cart-error', "There is not enough stock for the quantity you required of {$this->product->title}");
            return;
        }

        $this->quantity++;
        $this->total = $this->product->price * $this->quantity;
        $cart->products()->syncWithoutDetaching([
            $this->product->id => ['quantity' => $this->quantity],
        ]);

        $cart->touch();
        cookie()->queue(app(CartService::class)->makeCookie($cart));
        $this->dispatch('cartUpdated');
    }

    public function subtract()
{
    $cart = app(CartService::class)->getFromCookieOrCreate();

    // Reducir la cantidad
    $this->quantity--;
    $this->total = $this->product->price * $this->quantity;

    // Si la cantidad llega a 0 o menos, eliminamos el producto del carrito
    if ($this->quantity <= 0) {
        // Eliminar el producto del carrito
        $cart->products()->detach($this->product->id);
        
        // Actualizamos la cookie después de la eliminación
        $cart->touch();
        cookie()->queue(app(CartService::class)->makeCookie($cart));

        // Disparamos el evento de eliminación
        $this->dispatch('product-removed', $this->product->id);
    } else {
        // Si la cantidad es mayor que 0, actualizamos la cantidad
        $cart->products()->syncWithoutDetaching([
            $this->product->id => ['quantity' => $this->quantity],
        ]);
        
        // Actualizamos la cookie después de la actualización
        $cart->touch();
        cookie()->queue(app(CartService::class)->makeCookie($cart));
    }

    // Disparamos el evento para actualizar el carrito
    $this->dispatch('cartUpdated');
}

    public function remove()
    {
        // Eliminar el producto del carrito
        $cart = app(CartService::class)->getFromCookieOrCreate();
        $cart->products()->detach($this->product->id);

        // Actualizar el carrito en el cookie
        $cart->touch();
        cookie()->queue(app(CartService::class)->makeCookie($cart));

        // Disparar evento para actualizar vista
        $this->dispatch('product-removed', $this->product->id);
        $this->dispatch('cartUpdated');
        
    }

    public function render()
    {
        return view('livewire.cart-item-manager');
    }
}

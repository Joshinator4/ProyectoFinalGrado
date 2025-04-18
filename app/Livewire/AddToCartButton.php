<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use \Illuminate\Validation\ValidationException;

class AddToCartButton extends Component
{
    public Product $product;

    public function addToCart()
    {
        $cart = app('App\Services\CartService')->getFromCookieOrCreate();

        $quantity = $cart->products()
                         ->find($this->product->id)
                         ->pivot
                         ->quantity ?? 0;

        if ($this->product->stock < $quantity + 1) {
            // throw ValidationException::withMessages([
            //     'product'=> "There is not enough stock for the quantity you required of {$this->product->title}"
            // ]);
            $this->dispatch('cart-error', "There is not enough stock for the quantity you required of {$this->product->title}");
            
        }else{
            $cart->products()->syncWithoutDetaching([
                $this->product->id => ['quantity' => $quantity + 1],
            ]);
    
            $cart->touch();
            cookie()->queue(app('App\Services\CartService')->makeCookie($cart));

            // 🔁 Actualizar contador
            $this->dispatch('cartUpdated');
        }


    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;

class ProductCartToggle extends Component
{
    public Product $product;
    public bool $inCart = false;

    protected $listeners = ['cartUpdated' => 'checkIfInCart'];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->checkIfInCart();
    }

    public function checkIfInCart()
    {
        $cart = app(CartService::class)->getFromCookieOrCreate();
        $this->inCart = $cart->products->contains('id', $this->product->id);
    }

    public function render()
    {
        return view('livewire.product-cart-toggle');
    }
}


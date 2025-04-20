<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Services\CartService;

class CartProductList extends Component
{
    public $products;  // colección con cada producto + quantity + subtotal
    public float $total = 0; // total de toda la tabla
    protected $listeners = ['refreshCart' => '$refresh'];


    public function mount()
    {
        $cart = app(CartService::class)->getFromCookieOrCreate();

        // Sacamos solo los que siguen en el carrito, con pivot y images
        $this->products = $cart
            ->products()
            ->with('images')
            ->get()
            ->map(function($p) {
                $p->quantity = $p->pivot->quantity;
                $p->subtotal = $p->price * $p->quantity;
                return $p;
            });

        // Calculamos el gran total
        $this->total = $this->products->sum('subtotal');
    }

    public function add($productId)
    {
        $cart = app(CartService::class)->getFromCookieOrCreate();
        $product = Product::findOrFail($productId);

        $currentQty = $cart->products()->find($productId)?->pivot?->quantity ?? 0;

        if ($currentQty >= $product->stock) {
            //$this->dispatch('product-removed');
            $this->dispatch('cart-error',
                "There is not enough stock for the quantity you required of {$product->title}"
            );
            $this->mount(); 
            return;
        }

        $cart->products()->syncWithoutDetaching([
            $productId => ['quantity' => $currentQty + 1],
        ]);

        $cart->touch();
        cookie()->queue(app(CartService::class)->makeCookie($cart));

        $this->mount();          // recarga products y total
        $this->dispatch('cartUpdated');
    }

    public function subtract($productId)
    {
        $cart = app(CartService::class)->getFromCookieOrCreate();
        $currentQty = $cart->products()->find($productId)?->pivot?->quantity ?? 0;

        if ($currentQty <= 1) {
            $cart->products()->detach($productId);
        } else {
            $cart->products()->syncWithoutDetaching([
                $productId => ['quantity' => $currentQty - 1],
            ]);
        }

        $cart->touch();
        cookie()->queue(app(CartService::class)->makeCookie($cart));

        $this->mount();
        $this->dispatch('cartUpdated');
    }

    public function remove($productId)
    {
        $cart = app(CartService::class)->getFromCookieOrCreate();
        $cart->products()->detach($productId);
        $cart->touch();
        cookie()->queue(app(CartService::class)->makeCookie($cart));

        $this->mount();
        $this->dispatch('cartUpdated');
        $this->dispatch('product-removed');
    }

    public function render()
    {
        return view('livewire.cart-product-list');
    }
}

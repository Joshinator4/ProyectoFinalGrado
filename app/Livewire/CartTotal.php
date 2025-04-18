<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartTotal extends Component
{
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'updateTotal'];

    public function mount()
    {
        $this->updateTotal();
    }

    public function updateTotal()
    {
        $cart = app(CartService::class)->getFromCookieOrCreate();
        $this->total = $cart->total;
    }

    public function render()
    {
        return view('livewire.cart-total');
    }
}

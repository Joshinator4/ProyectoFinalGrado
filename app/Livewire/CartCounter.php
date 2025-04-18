<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartCounter extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function mount()
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->count = app(CartService::class)->countProducts();
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}

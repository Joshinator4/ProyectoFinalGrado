
    {{-- Zona izquierda: Add to cart / Cart Manager --}}
    <div class="d-flex align-items-center gap-3">
        
        @if ($inCart)
            <div class="flex-grow-1">
                @livewire('cart-item-manager', ['product' => $product, 'route' => url()->current()], key($product->id))
            </div>
        @else
            <div class="flex-grow-1">
                @livewire('add-to-cart-button', ['product' => $product], key('add-'.$product->id))
            </div>
        @endif
    </div>


    {{-- Zona izquierda: Add to cart / Cart Manager --}}
    <div class="d-flex align-items-center gap-3">
        @if ($inCart)
            @livewire('cart-item-manager', ['product' => $product], key($product->id))
        @else
            @livewire('add-to-cart-button', ['product' => $product], key('add-'.$product->id))
        @endif
    </div>

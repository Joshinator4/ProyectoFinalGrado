<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
    {{-- Zona izquierda: Add to cart / Cart Manager --}}
    <div class="d-flex align-items-center gap-3">
        @if ($inCart)
            @livewire('cart-item-manager', ['product' => $product], key($product->id))
        @else
            @livewire('add-to-cart-button', ['product' => $product], key('add-'.$product->id))
        @endif
    </div>

    {{-- Zona derecha: Botón Show Product / Go Back --}}
    <div class="d-flex align-items-center gap-3">
        @if (Route::currentRouteName() !== 'products.show')
            <a class="btn btn-primary" href="{{ route('products.show', ['product' => $product->id]) }}">
                Show Product
            </a>
        @else
            <a class="btn btn-secondary" href="{{ url()->previous() }}">
                Go Back
            </a>
        @endif
    </div>
</div>
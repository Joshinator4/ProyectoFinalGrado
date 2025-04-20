<div class="d-flex flex-column gap-2">
    {{-- Texto en una línea arriba --}}
    <p class="card-text mb-0">
        <strong>{{ $quantity }} in your cart ({{ $total == 0 ? number_format($product->price, 2) : number_format($total, 2) }}€)</strong>
    </p>

    {{-- Botones en fila debajo --}}
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-2">
            <button wire:click="subtract" class="btn btn-warning btn-md">-</button>
            <span class="px-3 fw-bold" style="font-size: 1.2rem;">{{ $quantity }}</span>
            <button wire:click="add" class="btn btn-success btn-md">+</button>
        </div>

        <button wire:click="remove" class="btn btn-danger btn-md">Remove</button>
    </div>
</div>


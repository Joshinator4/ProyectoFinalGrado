
<div>
    <p class="card-text">
        <strong>{{ $quantity }} in your cart ({{ number_format($total, 2) }}€)</strong>
    </p>
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button wire:click="subtract" class="btn btn-warning btn-md">-</button>
            <span class="px-3" style="font-size: 1.2rem; font-weight: bold;">{{ $quantity }}</span>
            <button wire:click="add" class="btn btn-success btn-md">+</button>
        </div>
        <button wire:click="remove" class="btn btn-danger btn-md">Remove</button>
    </div>
</div>


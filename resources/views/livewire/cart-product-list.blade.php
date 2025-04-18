<div class="table-responsive">
    <table class="table table-striped">
        <thead class="thead-light">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $p)
            <tr>
                <td>
                    <img src="{{ asset($p->images->first()->path) }}"
                         style="width:80px;margin-right:8px;">
                    {{ $p->title }}
                </td>
                <td>€{{ number_format($p->price, 2) }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <button wire:click="subtract({{ $p->id }})"
                                class="btn btn-warning btn-sm">–</button>
                        <span>{{ $p->quantity }}</span>
                        <button wire:click="add({{ $p->id }})"
                                class="btn btn-success btn-sm">+</button>
                    </div>
                </td>
                <td>€{{ number_format($p->subtotal, 2) }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('products.show', ['product' => $p->id]) }}">Show Product</a>
                    <button wire:click="remove({{ $p->id }})"
                            class="btn btn-danger">
                        Remove
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
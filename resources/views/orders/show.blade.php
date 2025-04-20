@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Order #{{ $order->id }}</h1>
@if($order->orderDetails->isEmpty())
        <div class="alert alert-warning">
            <strong>This order has no details.</strong>
        </div>
    @else
        @if($order->status === 'pending')
            <div class="text-center mb-3">
                <form class="d-inline"
                    method="POST"
                    action="{{ route('orders.store') }}"
                    >
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <button type="submit" class="btn btn-success btn-lg">Confirm Order</button>
                </form>
                
            </div>
        @else
            <div class="text-center mb-3">        
                <a href="{{ route('orders.download', $order) }}"
                                        class="btn btn-warning btn-lg">
                                        Download PDF
                                    </a>
            </div>   
        @endif
        <h4 class="text-center">
            <strong>Order Total: €{{ $order->orderDetails->sum(function($detail) {
                                    return $detail->price * $detail->quantity;
                                }) }}</strong>
        </h4>

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
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>
                            {{-- Puedes usar un placeholder para la imagen o un campo si la relación está definida --}}
                            <img src="{{ $detail->product->images->isNotEmpty() ? asset($detail->product->images->first()->path) : asset('placeholder.jpg') }}" style="width: 100px; height: 140px;" alt="{{ $detail->product->title }}">
                            {{ $detail->product->title }}
                        </td>
                        <td>{{ $detail->product->price }}€</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>
                            <strong>{{ $detail->quantity * $detail->product->price }}€</strong>
                        </td>
                        <td><a class="btn btn-primary" href="{{route('products.show', ['product'=>$detail->product->id])}}">Show Product</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endsection
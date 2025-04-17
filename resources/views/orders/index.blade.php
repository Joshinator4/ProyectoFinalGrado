{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Orders</h1>

        {{-- Si el usuario no tiene órdenes --}}
        @if ($orders->isEmpty())
            <p>You don't have any orders yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Total Products</th>
                            <th>Total Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @if( $order->orderDetails->sum('quantity') >0)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ $order->updated_at->format('d-m-Y H:i') }}</td>
                                    <td>{{ $order->orderDetails->sum('quantity') }}</td>

                                    {{-- Calculamos el precio total de la orden sumando el precio de todos los productos --}}
                                    <td>
                                        €{{ $order->orderDetails->sum(function($detail) {
                                            return $detail->price * $detail->quantity;
                                        }) }}
                                    </td>

                                    <td>
                                        <!-- Enlace a los detalles de la orden  -->
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">View</a>



                                        <!-- Si la orden está pendiente, podemos agregar un botón para pagar  -->
                                        @if($order->status === 'pending')
                                            <form class="d-inline"
                                                method="POST"
                                                action="{{ route('orders.store') }}"
                                                >
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                <button type="submit" class="btn btn-success">Confirm Order</button>
                                            </form> 
                                        @endif

                                        <a href="{{ route('orders.download', $order) }}"
                                            class="btn btn-warning">
                                            Download PDF
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>    
        @endif
    </div>
@endsection

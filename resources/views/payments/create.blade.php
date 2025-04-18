@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 class="mb-4">Payment Details</h1>

                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="mb-3">Order #{{ $order->id }}</h4>
                        <p><strong>Total:</strong> €{{ $order->orderDetails->sum(function($detail) {
                                    return $detail->price * $detail->quantity;
                                }) }}</p>

                        <form method="POST" action="{{ route('orders.payments.store', ['order' => $order->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-lg btn-success w-100">
                                Pay with Stripe
                            </button>
                        </form>

                        <p class="mt-3 text-muted small">
                            You will be redirected to a secure Stripe checkout page.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

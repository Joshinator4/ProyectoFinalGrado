@extends('layouts.app')

@section('content')
    <div class="container mt-5 text-center">
        <div class="alert alert-danger">
            <h2 class="mb-3">❌ Payment Canceled</h2>
            <p>Your payment was canceled. You can try again whenever you're ready.</p>
        </div>

        <a href="{{ route('orders.payments.create', ['order' => $order->id]) }}" class="btn btn-warning mt-3">
            Retry Payment
        </a>
    </div>
@endsection

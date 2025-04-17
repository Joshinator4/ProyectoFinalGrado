@extends('layouts.app')

@section('content')
    <div class="container mt-5 text-center">
        <div class="alert alert-success">
            <h2 class="mb-3">✅ Payment Successful</h2>
            <p>Thank you! Your payment was processed successfully.</p>
        </div>

        <a href="{{ route('main') }}" class="btn btn-primary mt-3">
            Back to Home
        </a>
    </div>
@endsection

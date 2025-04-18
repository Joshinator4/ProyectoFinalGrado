<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request, Order $order)
{
    // Establecer la clave secreta de Stripe
    \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

    // Crear un PaymentIntent
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $order->total * 100, // convertir a centavos
        'currency' => 'usd',
    ]);

    // Devolver el client secret al frontend
    return response()->json([
        'clientSecret' => $paymentIntent->client_secret,
    ]);
}

}

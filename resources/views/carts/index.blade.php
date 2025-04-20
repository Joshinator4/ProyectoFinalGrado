@extends('layouts.app')

@section('content')
    <!-- Esta vista esta recibiendo la informacion adquirida en el modelo, y se envia aqui a través del controlador con metodo with(['product'=>$product]) -->
    <!-- En este caso se envia la informacion como product, si en el with se pone por ejemplo with(['element'=>$product]) aqui se accederia a los valores con $element-->
	<h1>Your cart</h1>



    @if(!isset($cart) || $cart->products->isEmpty())
        <div class="alert alert-warning">
            <strong>Your cart is empty</strong>
        </div>

    @else
        {{-- de esta forma accedemos al precio total del carro accediendo al atributo 'creado' total --}}
        <h4 class="text-center">
            <!-- <strong>Grand Total: {{ $cart->total }}€</strong> -->
            @livewire('cart-total')
        </h4>
        <div class="text-center">
            <a class="btn btn-success mb-3 w-100 btn-lg" href="{{ route('orders.create') }}">
                Start Order
            </a>
        </div>
        <div class="row">
            @foreach ($cart->products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <!--ASI incluimos componentes de blade para reutilizar código -->
                    @include('components.product-cart')
                </div>
            @endforeach

        </div>
    @endif
@endsection

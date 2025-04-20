@extends('layouts.app')

@section('content')
    <!-- Esta vista esta recibiendo la informacion adquirida en el modelo, y se envia aqui a través del controlador con metodo with(['product'=>$product]) -->
    <!-- En este caso se envia la informacion como product, si en el with se pone por ejemplo with(['element'=>$product]) aqui se accederia a los valores con $element-->
	{{-- <h1>name of product: {{ $product->title }} - id: ({{ $product->id }})</h1>
	<p>description: {{ $product->description }}</p>
	<p>price: {{ $product->price }}</p>
	<p>stock: {{ $product->stock }}</p>
	<p>status: {{ $product->status }}</p> --}}
    <!--ASI incluimos componentes de blade para reutilizar código -->

    {{-- Se crea un estilo antes del include para que se muestre como lo deseamos --}}
    <div class="row justify-content-center">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            @include('components.product-cart')
        </div>
        
    </div>

@endsection

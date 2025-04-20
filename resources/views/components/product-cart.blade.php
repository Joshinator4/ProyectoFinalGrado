{{--! Esto es un componente de blade que se usa para reutilizarse en varias vistas --}}
<div class="card h-100 d-flex flex-column">
    {{-- asset es un helper de laravel que se usa para acceder a algo --}}
    {{-- @dd($product) --}}
    <div class="card">
        {{--! Se le llama id de forma distinta para cada producto añadiendo el id del producto al final del carousel --}}
        <div id="carousel{{ $product->id }}" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">

                @foreach ($product->images as $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">{{--! se recorren las imagenes para asignarles que son un item del carousel y se hace un condicional que si es la primera del ciclo foeach sea la active (la que se muestra predefinida)--}}
                        <img class="d-block w-100 card-img-top" src="{{ asset($image->path) }}" height="500">{{--se pone la imagen accediendo al path por medio de asset --}}
                    </div>
                @endforeach
            </div>
            {{--! Esto son los botones de atrás y alante  dentro de las imagenes --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $product->id }}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $product->id }}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="card-body flex-grow-1 d-flex flex-column justify-content-between" style="background-color: #fff9c4">
        <h4 class="text-right"><strong>€{{$product->price}}</strong></h4>
        <h5 class="card-title">{{$product->title}}</h5>
        <p class="card-text">{{$product->description}}</p>
        <p class="card-text"><strong>{{$product->stock}} left</strong></p>


        @if (isset($cart)) {{--?Si estamos en el carrito se muestra un tipo de formulario --}}
            {{-- Se muestra la informacion de cantidad de produto en el carro y el precio total de cada producto --}}
            <!-- <p class="card-text"><strong>{{$product->pivot->quantity}} in your cart ({{$product->total}}€)</strong></p> -->
            <!-- <form class="form-inline"
            method="POST"
            action="{{ route('products.carts.destroy', ['cart' => $cart->id,'product' => $product->id]) }}"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning">Remove Product</button>
            </form> -->
            @livewire('cart-item-manager', ['product' => $product], key($product->id))
        @else {{--?Si no estamos en el carrito se muestra otro tipo de formulario --}}
            <!-- <div class="d-flex justify-content-between"> -->
                <!-- <form class="form-inline"
                method="POST"
                action="{{ route('products.carts.store', ['product' => $product->id]) }}"
                >
                    @csrf
                    <button type="submit" class="btn btn-success">Add to Cart</button>
                </form> -->

                <!-- @livewire('add-to-cart-button', ['product' => $product]) -->
                
                @livewire('product-cart-toggle', ['product' => $product], key('toggle-' . $product->id))

            <!-- </div> -->
        @endif


    </div>
</div>
{{-- <h1>name of product: {{ $product->title }} - id: ({{ $product->id }})</h1>
<p>description: {{ $product->description }}</p>
<p>price: {{ $product->price }}</p>
<p>stock: {{ $product->stock }}</p>
<p>status: {{ $product->status }}</p> --}}
<script>
    Livewire.on('product-removed', () => {
        location.reload();
    });
</script>


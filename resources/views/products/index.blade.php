<!--Con extends se carga la plantilla de html que hemos creado en layouts master-->
@extends('layouts.app')

<!--Con section se bindea el contenido del yield creada en la plantilla en este caso será content-->
@section('content')
    <h1>List of Products</h1>

    <!-- Se añaden links para que sea mas sencillo acceder a las rutas-->
    <!-- añadiendo una ruta en el href se llama a las rutas con su respectivo llamado a los métodos del controlador -->
    <a class="btn btn-success mb-3" href="{{route('products.create')}}">Create Product</a>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('products.index') }}">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search products by name" value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <!--Se genera una condicional de blade de esta forma, siempre hay que cerrarla con {{-- @endif--}}-->
    <!--Con la funcion de JS empty filtramos si está vacia o no-->
    {{--@if (empty($products))--}}
    <!--Con la funcion de blade empty filtramos si está vacia o no. siempre hay que cerrarla con {{-- @endempty--}}-->
    @empty ($products)
        <div class="alert warning">
            This list of products is empty
        </div>

    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id}}</td>
                            <td>{{ $product->title}}</td>
                            <td>{{ $product->description}}</td>
                            <td>{{ $product->price}}</td>
                            <td>{{ $product->stock}}</td>
                            <td>{{ $product->status}}</td>
                            <td>
                                <!-- añadiendo una ruta en el href se llama a las rutas con su respectivo llamado a los métodos del controlador -->
                                <!-- en los casos de show y edit hay que pasarle como parametro a la ruta el id del producto, como lo estamos recorriendo con el foreach, se le pasa el atributo id del producto -->
                                <a class="btn btn-primary" href="{{route('products.show', ['product'=>$product->id])}}">Show Product</a>
                                {{-- Así sería si queremos pasarle el titulo en vez del id al método --}}
                                {{-- <a class="btn btn-link" href="{{route('products.show', ['product'=>$product->title])}}">Show Product</a> --}}
                                <a class="btn btn-warning" href="{{route('products.edit', ['product'=>$product->id])}}">Edit Product</a>

                                <!-- se realiza un formulario para poder hacer el DELETE ya que es un metodo falseado de POST.  -->
                                <form method="POST" class="d-inline" action="{{route('products.destroy', ['product'=>$product->id])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @endempty
@endsection

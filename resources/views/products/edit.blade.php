@extends('layouts.app')

@section('content')
<h1>Edit a product</h1>
<!-- En la accion del formulario se llama a la ruta por el nombre productos.update -->
<!-- El metodo es de tipo POST a la ruta llamada products.update pero esta ruta recibe un parámetro, el cual es el id del producto a editar.-->
<!-- Se le pasa un segundo parametro a route con elproducto que envia el metodo edit del ProductController -->
<form method="POST" action="{{ route('products.update', ['product' => $product->id]) }}" enctype="multipart/form-data">
    <!-- Hay que incluir csrf en nuestros formularios para que sean seguros -->
    @csrf

    <!-- Los navegadores solo aceptan POST o GET, aqui aparece el falseamiento de método, Laravel hace pasar PUT o PATCH como POST -->
    @method('PUT')
    <div class="form-row">
        <label>Title</label>
        <!--Se usa la sintaxis en old('title') ?? $product->title la doble interrogación quiere decir que si existe old() use old, si no usará el valor de la variable $product-->
        <input class="form-control" type="text" name="title" value="{{ old('title') ?? $product->title}}" required>
    </div>
    <div class="form-row">
        <label>Description</label>
        <input class="form-control" type="text" name="description" value="{{ old('description') ?? $product->description}}" required>
    </div>
    <div class="form-row">
        <label>Price</label>

        <input class="form-control" type="number" min="1.00" step="0.01" name="price" value="{{ old('price') ??$product->price}}" required>
    </div>
    <div class="form-row">
        <label>Stock</label>

        <input class="form-control" type="number" min="0" name="stock" value="{{ old('stock') ?? $product->stock}}" required>
    </div>
    <div class="form-row">
        <label>Status</label>
        <select class="custom-select" name="status" value="{{$product->status}}" required>
            <!--Se usa la sintaxis siguiente para hacer una doble condicion, si el valor antiguo es... haz... si no utiliza el valor de la variable $producto y si es.. haz... si no...-->
            <option {{old('status') =='available' ? 'selected' : ($product->status == 'available' ? 'selected' : '')}}value="available">
                available
            </option>
            <option {{old('status') =='unavailable' ? 'selected' : ($product->status == 'unavailable' ? 'selected' : '')}}value="unavailable">
                unavailable
            </option>
        </select>
    </div>
    <div class="form-row">
        <label>{{ __('Images') }}</label>
        <div class="custom-file">
            <input type="file" accept="image/*" name="images[]" class="custom-file-input" multiple>
            <label class="custom-file-label">Product images...</label>
        </div>

    </div>
    <div class="form-row mt-3">
        <button type="submit" class="btn btn-primary btn-lg">Edit product</button>
    </div>
</form>

@endsection

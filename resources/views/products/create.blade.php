@extends('layouts.app')

@section('content')
	<h1>Create a product</h1>
    <!-- En la accion del formulario se llama a la ruta por el nombre productos.store -->
    <!-- El metodo es de tipo POST a la ruta llamada products.store-->
	<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        <!-- Hay que incluir csrf en nuestros formularios para que sean seguros -->
        @csrf
        <div class="form-row">
            <label>Title</label>
            <!-- en class se pone form-control que es de bootstrap, tipo de entrada y que es requerido(required)-->
            <!-- se utiliza value=" old() " para que coja el valor antiguo de la casilla en caso de que salte error-->
            <input class="form-control" type="text" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="form-row">
            <label>Description</label>
            <input class="form-control" type="text" name="description" value="{{ old('description') }}" required>
        </div>
        <div class="form-row">
            <label>Price</label>
            <!-- Se le pone un minimo al precio que sea 1 y step es para que pueda aumentar de 0.01 en 0.01 si hace falta-->
            <input class="form-control" type="number" min="1.00" step="0.01" name="price" value="{{ old('price') }}" required>
        </div>
        <div class="form-row">
            <label>Stock</label>
            <!-- Se le pone un minimo al stock porque puede haber minimo 0 unidades-->
            <input class="form-control" type="number" min="0" name="stock" value="{{ old('stock') }}" required>
        </div>
        <div class="form-row mt-3">
            <label>Status</label>
            <select class="custom-select" name="status" required>
                <!-- Se pone selected para que sea el que aparece por defecto-->
                <option value="" selected>Select...</option>
                <!-- se utiliza value=" old() " para que coja el valor antiguo de la casilla en caso de que salte error-->
                <option {{old('status') == 'available' ? 'selected' : ''}} value="available">available</option>
                <option {{old('status') == 'unavailable' ? 'selected' : ''}} value="unavailable">unavailable </option>
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
            <button type="submit" class="btn btn-primary btn-lg">Crate product</button>
        </div>
    </form>

@endsection

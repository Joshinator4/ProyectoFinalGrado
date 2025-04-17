<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Learn Laravel</title>
</head>
<body>
    <!-- Dump mostrará en tiempo de ejecucion los errores que hay-->
    {{--@dump($errors)--}} 
    <!-- Esto filtra si hay algún error enviado desde el controlador  salte aquí, de esta forma solo se hace 1 vez por esta plantilla-->
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error')}}
        </div>
        
    @endif

    <!-- Esto filtra si hay algún mensaje de exito para mostrarlo-->
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success')}}
        </div>
        
    @endif

    <!-- esto coge los posibles errores generados por validate del conjunto de reglas generadas en el controlador, any es por si esta vacío (no hay errores)-->
    @if (isset($errors) && $errors->any())
        <!-- se recorre la lista de errores mostrandolos en una lista -->
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{  $error  }}</li>
                @endforeach
            </ul>
        </div>
        
    @endif

    

    <!--yield indica que aqui ira una sección de la vista-->
    @yield('content')
</body>
</html>

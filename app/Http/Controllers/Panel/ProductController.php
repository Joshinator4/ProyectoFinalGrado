<?php

//Un crontrolador es el componente encargado de manejar la logica del negocio en cosas como crear, actualizar, eliminar, mostrar, leer, filtrar...etc debe ser realizado en un controlador
//nos salva de lidiar con la logica de negocio en el lugar incorrecto y nos permite agregar mas complejidad en las acciones que necesitamos realizar

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\PanelProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    //!Este constructor se usa para que no se pueda usar ningun método/vista si el usuario no está loggeado usando el middleware auth
    //!El middleware proporciona un mecanismo conveniente para inspeccionar y filtrar las solicitudes HTTP que ingresan a su aplicación. Por ejemplo, Laravel incluye un middleware que verifica que el usuario de su aplicación esté autenticado
    public function __construct(){
        $this->middleware("auth")->except('show');// se puede usar ->except(['nombre de la función1', 'nombre de la función2']) y ->only('nombre de la función')
    }

    public function index(Request $request){
        //! Esto es utilizando Query Builder (no es recomendable, lo mejor es utilizar el ORM Eloquent) esto no esta usando el modelo. Esto no es escalable
        // $products = DB::table('products')->get();
        // mostramos lo datos parando la ejecucuion
        // dd($products);

        //!Esto descarga una lista completa del modelo producto
        // $products = Product::all();
        // return $products; si se utiliza así devuelve los datos en formato json
        // dd($products);

        // Verificar si hay un término de búsqueda y aplicarlo
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            // Si se proporciona un término de búsqueda, filtrar los productos por nombre
            $products = PanelProduct::where('title', 'like', '%' . $searchTerm . '%')->get();
            return view("products.index")->with([
            'products'=> $products,
            ]);
        } else {
            return view('products.index')->with([
                // 'products'=> PanelProduct::withoutGlobalScope(AvailableScope::class)->get(),//!Se desea que se muestren todos los productos, disponibles y no disponibles. Se ignora el global scope AvailableScope. Asi se genera el problema de que se muestran los unavailable pero no dejar entrar en los metodos edit, show, delete porque ignora estos productos por el global scope
                // 'products'=> PanelProduct::all(),//?Se ha creado oto modelo PanelProduct que hereda del modelo Product para poder acceder a estos métodos, usando dicho modelo creado, ya que ignrará el global scope
                'products'=> PanelProduct::without('images')->get(), //*Se hace esto para recibir los productos sin imagenes ya que no se van a utilizar
            ]);
        }

        


        // return view('products.index')->with([
        //     // 'products'=> PanelProduct::withoutGlobalScope(AvailableScope::class)->get(),//!Se desea que se muestren todos los productos, disponibles y no disponibles. Se ignora el global scope AvailableScope. Asi se genera el problema de que se muestran los unavailable pero no dejar entrar en los metodos edit, show, delete porque ignora estos productos por el global scope
        //     // 'products'=> PanelProduct::all(),//?Se ha creado oto modelo PanelProduct que hereda del modelo Product para poder acceder a estos métodos, usando dicho modelo creado, ya que ignrará el global scope
        //     'products'=> PanelProduct::without('images')->get(), //*Se hace esto para recibir los productos sin imagenes ya que no se van a utilizar
        // ]);
    }

    public function create (){
        return view('products.create');
        // return "This is the form to create a product from CONTROLLER";
    }


    //la funcion store recibirá un formulario de la funcion create
    public function store (ProductRequest $request){
        //!Pasando el request por parámetro del request creado anteriormente se hace la validación automáticamente pudiendo reutilizarla.

        //!aqui se generan las reglas en un array
        // $rules = [
        //     'title'=> ['required', 'max: 255'],
        //     'description' => ['required','max:1000'],
        //     'price'=> ['required','min:1'],
        //     'stock'=> ['required','min:0'],
        //     'status'=>['required', 'in:available, unavailable']
        // ];
        //!De esta forma se validan las reglas, si falla alguna se disparará una excepcion y se devuelve a la pagina donde se ha lanzado la excepcion
        // request()->validate($rules);

        //Vamos a filtrar que al crear un producto si esta disponible no sea posible que el stock sea 0 o viceversa
        // if($request->status == 'available' && $request->stock == 0){ //!Se puede usar el request enviado por parámetro $request o el helper(metodo)request()
            //session()->put('error', 'if the product is available must have stock');
            //!Con flash solo aparece el error unicamente hasta la siguiente petición.
            //error es el elemento que se debe captar y el mensaje es valor del elemento error
            // session()->flash('error', 'if the product is available must have stock');
            //se redirige al momento anterior al fallo y con withInput(request()->all()) se le envian los datos ya introducidos por el usuario para su posteriro solución
        //     return redirect()
        //             ->back()
        //             ->withInput($request->all())//! $request ->validated() solo pasa los atributos que se hayan validado. ->all()pasa todo
                        //se puede ahorrar el lanzamiento del error de flash() con ->witherros
        //             ->withErrors('if the product is available must have stock');
        // }

        //se puede hacer que borre el mensaje de error así pero solo si se ha completado con exito la creación de un producto en este caso en concreto
        //session()->forget('error');


        // $product = Product::create([
            //Una forma sencilla de traerse los datos del POST realizado en el formulario de la vista de create.blade.php es con request()->nombre del input (name="title")por ejemplo
            //     'title' => request()->title,
            //     'description' => request()->description,
            //     'price' => request()->price,
            //     'stock' => request()->stock,
            //     'status'=> request()->status,
            // ]);

        //!Esta forma es mas rapida y directa.Se trae los datos del POST realizado en el formulario de la vista de create.blade.php. Este request solo pasará los atributos asignados en fillable en el model Product. ESto puede traer mas atributos que serán ignorados si no estan en fillable


        $product = PanelProduct::create(request()->all());//?Se ha creado oto modelo PanelProduct que hereda del modelo Product para poder acceder a estos métodos, usando dicho modelo creado, ya que ignorará el global scope

        //*Esto recorre las imagenes enviadas desde el formulario y las guarda en el storage del proyecto (con store) y añade el producto y las respectivas imagenes a la BBDD con el path de las imagenes guardadas en el storage del proyecto.
        foreach ($request->images as $image) {
            $product->images()->create([
                'path' => 'images/' . $image->store('products', 'images')//! 'images/' es para que lo guarde en public/images/ y se le añade el nombre de la imagen con el link que se ha creado en filesystems por medio del metodo store('', ''). en store el 1er parametro es la carpeta donde se va a alamacenar la imagen y el 2º es el nombre del storage que se ha creado con su correspondiente link
            ]);
        }

        //Así devolveriamos mensajes de exito
        //session()->flash('success', "The new product with id: {$product->id} was created");

        //Así devolveriamos el objeto creado
        // return $product;

        // de esta forma se redirige a la ruta que queramos
        // return redirect()->back(); vuelve a la página anterior a en la que estemos
        // return redirect()->action([MainController::class, 'index']); manda la accion del controlador indicado
        return redirect()
                ->route('products.index')//con route() enviamos a la ruta indicada. Es mejor usar esta opcion por si cambia el nombre del método no tienes que cambiar nada aquí. La ruta es a una vista!!!
                ->withSuccess("The new product with id: {$product->id} was created");
                //se puede usar with('success', "The new product with id: {$product->id} was created")de las 2 formas se creará en la sesion una variable success par enviarle los mensajes deseados
    }

    //? SE HA CAMBIADO EL TIPO (model) DE PRODUCTO RECIBIDO A PanelProduct PARA PODER ADAPTARSE AL CAMBIO PARA NO USAR EL GLOBALSCOPE
    //se puede usar el nombre del modelo anets de la variable pasada por parámetro a la funcion para que Laravel internamente haga el findorfail()
    public function show (PanelProduct $product){
        //Esto es utilizando Query Builder (no es recomendable, lo mejor es utilizar el ORM Eloquent) esto no esta usando el modelo. Esto no es escalable
        //obtenemos un elemento de la tabla products filtrandolo por el id que se le introducirá. Como sabemos que solo devuelve 1 producto, se usa first()
        // $product = DB::table("products")->where("id", $product)->first();
        //! tambien se puede hacer así porque buscamos por id. find busca por la clave principal devolviendo toda la linea
        //! $product = DB::table("products")->find($product);
        //mostramos lo datos parando la ejecucuion
        // dd($product);

        //!El metodo find busca en el modelo el producto con id que se le pasa por parámetro
        // $product= Product::find($product);
        //!El metodo find busca en el modelo el producto con id que se le pasa por parámetro. si no existe manda una excepcion de tipo 404
        // $product = Product::findOrFail($product);
        // dd($product);
        // return $product; si se utiliza así devuelve los datos en formato json

        //with recibe un array con los diferentes elementos que podemos enviar ['indiceDelArrayAsociativo'=>$valor]
        //!en este caso al indice se le envia product para ser consistente y como valor se la manda la variable $product con el producto encontrado en el metodo anterior findOrFail
        return view('products.show')->with(['product'=> $product]);
    }

    //? SE HA CAMBIADO EL TIPO (model) DE PRODUCTO RECIBIDO A PanelProduct PARA PODER ADAPTARSE AL CAMBIO PARA NO USAR EL GLOBALSCOPE
    //se puede usar el nombre del modelo anets de la variable pasada por parámetro a la funcion para que Laravel internamente haga el findorfail()
    public function edit (PanelProduct $product){
        //!desde aqui llamamos a la vista de edit y se le pasa la variable producto buscada por el id que se recibe del html
        return view('products.edit')->with(['product'=> $product]);
        // return "Showing the form to edit the product with id: {$product}";
    }

    //? SE HA CAMBIADO EL TIPO (model) DE PRODUCTO RECIBIDO A PanelProduct PARA PODER ADAPTARSE AL CAMBIO PARA NO USAR EL GLOBALSCOPE
    //se puede usar el nombre del modelo anets de la variable pasada por parámetro a la funcion para que Laravel internamente haga el findorfail()
    public function update (ProductRequest $request, PanelProduct $product){
        //!Pasando el request por parámetro del request creado anteriormente se hace la validación automáticamente pudiendo reutilizarla.

        //!aqui se generan las reglas en un array
        // $rules = [
        //     'title'=> ['required', 'max: 255'],
        //     'description' => ['required','max:1000'],
        //     'price'=> ['required','min:1'],
        //     'stock'=> ['required','min:0'],
        //     'status'=>['required', 'in:available, unavailable']
        // ];
        //!De esta forma se validan las reglas, si falla alguna se disparará una excepcion y se devuelve a la pagina donde se ha lanzado la excepcion
        // request()->validate($rules);
        $product->update($request->validated());//!Se puede usar el request enviado por parámetro $request o el helper(metodo)request()

        //*esto filtra si se envian o no imagenes nuevas en el momento de editar el producto. se envian nuevas imagenes hay que borrar las que ya habían
        if ($request->hasFile('images')) {
            foreach($product->images as $image) {
                //!se premia la consistencia porque esta imagen esta guardada en public/images con el mismo nombre que en el storage. por lo cual se puede usar el path añadiendo la raiz de storage en el metodo storage_path("app/public/{$image->path}")
                $path = storage_path("app/public/{$image->path}");//Nos quedamos con el path que se ha guardado en el storage del proyecto

                File::delete($path);//Se borra la imagen(archivo) con la ruta de donde esta

                $image->delete();//aqui se borra la informacion de la imagen en la base de datos
            }

            foreach ($request->images as $image) {
            $product->images()->create([
                'path' => 'images/' . $image->store('products', 'images')//! 'images/' es para que lo guarde en public/images/ y se le añade el nombre de la imagen con el link que se ha creado en filesystems por medio del metodo store('', ''). en store el 1er parametro es la carpeta donde se va a alamacenar la imagen y el 2º es el nombre del storage que se ha creado con su correspondiente link
            ]);
            }
        }



        // return $product;
        return redirect()
                ->route('products.index')//con route() enviamos a la ruta indicada. Es mejor usar esta opcion por si cambia el nombre del método no tienes que cambiar nada aquí. La ruta es a una vista!!!
                ->withSuccess("The new product with id: {$product->id} was edited");
                //se puede usar with('success', "The new product with id: {$product->id} was created")de las 2 formas se creará en la sesion una variable success par enviarle los mensajes deseados
    }

    //? SE HA CAMBIADO EL TIPO (model) DE PRODUCTO RECIBIDO A PanelProduct PARA PODER ADAPTARSE AL CAMBIO PARA NO USAR EL GLOBALSCOPE
    //se puede usar el nombre del modelo antes de la variable pasada por parámetro a la funcion para que Laravel internamente haga el findorfail()
    public function destroy (PanelProduct $product){

        $product->delete();

        // return $product;
        return redirect()->route('products.index') //con route() enviamos a la ruta indicada. Es mejor usar esta opcion por si cambia el nombre del método no tienes que cambiar nada aquí. La ruta es a una vista!!!
        ->withSuccess("The new product with id: {$product->id} was eliminated");
        //se puede usar with('success', "The new product with id: {$product->id} was created")de las 2 formas se creará en la sesion una variable success par enviarle los mensajes deseados
    }


}

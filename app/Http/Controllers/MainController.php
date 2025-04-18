<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index(Request $request)
    {

        // Verificar si hay un término de búsqueda y aplicarlo
        $searchTerm = $request->input('search');

        //$name = config("app.undefined", "welcome"); //esto va a buscar el valor de app.undefined, como no existe coge el valor por defecto que es "welcome"

        // dump( $name); son helpers para poder conocer el valor de la variable en el momento de la ejecución sin detenerla
        //dd($name); dd es igual que dump pero detiene la ejecucion en el

        // DB::connection()->enableQueryLog();

        //!esto es la llamada a un scope. Al implementarse el global scope creado AvailableScope ya no hace falta llamar al local scope scopeAvalable del modelo
        // $products = Product::available()->get();
        //!Ahora al usar el global scope creado AvailableScope se puede usar all() ya que realizará el filtrado de forma automática
        if ($searchTerm) {
            // Si se proporciona un término de búsqueda, filtrar los productos por nombre
            $products = Product::where('title', 'like', '%' . $searchTerm . '%')->get();
        } else {
            // Si no se proporciona un término de búsqueda, obtener todos los productos
            $products = Product::all();
        }

        return view("welcome")->with([
            'products'=> $products,
        ]);
    }
}

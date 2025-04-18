<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function edit(Request $request){
        return view('profiles.edit')->with([
            'user' => $request->user(),

        ]);
    }
    public function update(ProfileRequest $request){

        return DB::transaction(function () use ($request){
            $user = $request->user();//se coge el usuario de la peticion ($request)

            $user->fill(array_filter($request->validated()));//se rellena el con los datos verificados. Con array_filter nos quedamos solo con los campos que se hayan completado (no esten vacíos. Asi por ejemplo si no se añade una contraseña dejará la que ya tiene)


            if($user->isDirty('email')){//*se filtra si se ha cambiado el email con la funcion isDirty()
                $user->email_verified_at = null; //si se ha cambiado se pone el campo email verified a null
                $user->sendEmailVerificationNotification();//si se ha cambiado se envia el email de confirmacion
            }

            //!OJO SE ESTA CIFRANDO LA CONTRASEÑA EN EL MODELO USER CON UN SETTER

            $user->save();

            if($request->hasFile('image')){//*Se filtra si la petición tiene un campo introducido llamado image (sale de la view <input name="image"....>)
                if($user->image != null){//se filtra si ya tenia una foto el usuario para eliminarla
                    Storage::disk('images')->delete($user->image->path);//con este facade se borra la imagen de nuestro filesystem (), de nuestro archivo
                    $user->image->delete();//se borra de la BBDD la imagen del usuario

                }

                //*Una vez filtrado todo se guarda la nueva imagen introducida en el formulario de la view
                $user->image()->create([
                    'path' => $request->image->store('users', 'images'),//Se le indica que en la columna path del usuario en la BBDD se guarda la ruta desiganada en config/filesystems (1er parametro se le indica que va dentro de la ruta, dentro de una carpeta users y el 2º parametro se le indica el nombre del espacio en disco [COMPROBAR EN ARCHIVO INDICADO ANTERIORMENTE config...])
                ]);
            }

            return redirect()
                ->route('profile.edit')
                ->withSuccess('Profile Edited!');

        }, 5);

    }


}

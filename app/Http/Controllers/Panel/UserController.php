<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view("users.index")->with([
            'users' => User::all(),
        ]);
    }

    //!Este método cambia si es admin se le quita y si no lo es, se le pone como admin
    public function toggleAdmin(User $user){
        if($user->isAdmin()){
            $user->admin_since = null;
        }else{
            $user->admin_since = now();
        }
        $user->save();
        return redirect()
            ->route('users.index')
            ->withSuccess("Admin status for user {$user->id} was toggled.");
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess("User with ID {$user->id} was soft-deleted.");
    }
}

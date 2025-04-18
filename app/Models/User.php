<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // 'admin_since',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    //PARA LARAVEL 8 Y SUPERIORES SE HACE EL CAST AQUI
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'admin_since' => 'datetime',
        ];
    }

    //ESTO ES PARA LARAVEL 7 y anteriores
    //Esto es para trabajar con Carbon php. estos son los atributos que deben ser mutados a dates
    // protected $dates = [
    //     'admin_since',
    //  ];

     //esta funcion es para definir la relacion uno a muchos con order con hasMany. un usuario tiene muchas order
     public function orders(){
        return $this->hasMany(Order::class, 'customer_id');//!El segundo parámetro es para indicarle el nombre de la columna. Laravel piensa que se llama user_id (ya que viene de la tabla users) hay que hacerlo en user y en order
     }

     //esta funcion es para definir la relacion de usuarios con pagos a través de orders. un usuario tiene muchos payment. Relaciones de relaciones
     public function payments(){
        return $this->hasManyThrough(Payment::class,Order::class,'customer_id');//!1er parametro la clase a la que deseamos llegar, 2º a través de que clase se llega y 3º es la clave por la cual se llega (hay que indicarla por no llamarse de forma predefinida user_id)
     }


     //esta funcion define la relacion polimórfica uno a uno con image. Image puede ser de producto o de usuario
     public function image(){
        return $this->morphOne(Image::class,'imageable');//!1er argumento la clase imagen. 2º argumento el nombre de la columna de la relacion polimórfica
     }

     public function isAdmin(){
        if($this->admin_since != null && $this->admin_since->lessThanOrEqualTo(now())){
            return true;
        }
     }

     //!al ser un setter se ejecuta antes de guardar el dato en la BBDD
     public function setPasswordAtribrute($password){
        $this->attributes['password'] = bcrypt($password);//Se cifra la contraseña recibida y se pone en el atributo
        //!OJOOOOOOOOOOOOOOOO hay que tener cuidado de no cifrar 2 veces la contraseña quitar el cifrado en RegisterController (xq se cifra la contraseña cuando se regitra un usuario)
     }

     public function getProfileImageAttribute(){

        return $this->image
        ? "images/{$this->image->path}"
        : 'https://www.gravatar.com/avatar/404?d=mp';
     }
}

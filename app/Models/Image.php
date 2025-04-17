<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;
    protected $fillable = [
        'path',
    ] ;

    //esta funcion es para definir la relacion polimorfica con product y con user.
    public function imageable(){
        return $this->morphTo();//! si somos consistentes no hace falta pasar nada por parámetro. ESto identifica si es un user o un product
    }
}

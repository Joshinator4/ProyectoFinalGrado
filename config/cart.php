<?php
//!ESTO ES UN ARCHIVO DE CONFIGURACIÓN EN EL CUAL SE INCLUYEN NOMBRES DE VARIABLES ETC PARA SER REUTILIZADOS Y EN CASO DE CAMBIO VENIR AQUI Y CAMBIAR SOLO 1 VEZ
return [

    'cookie' => [
        //!env() es un helper que lee una variable de entrono llamada en este caso CART_COOKIE_NAME --> del archivo .env, el segundo parametro es el valor por defecto
        'name' => env('CART_COOKIE_NAME', 'cart_cookie'),
        'expiration' => 7 * 24*60,
    ],


];

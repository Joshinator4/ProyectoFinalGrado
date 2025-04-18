<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Image;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //!Se lanza con php artisan migarate:fresh --seed
        //!fresh rehace la BBDD y con seed se lanza el seeder para crear 50 productos en este caso
        //!tambien se puede lanzar php artisan db:seed  esto lanzara otros 50 productos pero añadiendolo a los datos que ya tiene la BBDD

        //Se crean 20 users
        $users = User::factory(20)
                        ->create()
                        ->each(function($user){
                            $image = Image::factory()//se crea una image de tipo user
                            ->user()
                            ->make();

                            $user->image()->save($image);//al user se le guarda una image de tipo user

                        });



        //Esto es para añadir ordenes asiganados a usuarios
        $orders = Order::factory(10)
                    ->make()//al hacer la instancia no se puede guardar como se haría con create()
                    ->each(function($order) use ($users){
                        $order->customer_id = $users->random()->id;//al customer_id de order se le pasa un id de user cualquiera generado anteriormente
                        $order->save();//finalmente se guarda la instancia creada con el id del user

                        $payment = Payment::factory()->make();
                        //$payment->order_id = $order->id();
                        //$payment->save();
                        $order->payment()->save($payment);//asi se le pasa al campo payment de order el id de $payment y se guarda
                    });

        $carts = Cart::factory(20)->create();

        //Para que sea realista nuestra BBDD a cada producto lo vamos a añadir a ordenes y a carritos. No todos los carritos tendrán productos
        $products = Product::factory(50)
                        ->create()//se crean los productos y se recorren
                        //!En el for each se recorre $products como $product y se usa las listas de $orders y $carts
                        ->each(function($product) use ($orders, $carts){//se recorren los prouctos para asiganarlos cada uno a una order y a un cart aleatorio
                            $order = $orders->random();//se coge una order aleatoria
                            //con ->products()->attach([])se le añade un producto con una cantidad a la order
                            $quantity = mt_rand(1, 3);
                            $order->products()->attach([
                                $product->id => ['quantity' => $quantity]
                            ]);

                            // ✅ Crear el order_detail justo después del attach
                            OrderDetail::create([
                                'order_id'   => $order->id,
                                'product_id' => $product->id,
                                'quantity'   => $quantity,
                                'price'      => $product->price,
                            ]);

                            $cart = $carts->random();//se coge un cart aleatorio

                            $cart->products()->attach([//con ->products()->attach([])se le añade un producto con una cantidad al cart
                                $product->id => ['quantity' => mt_rand(1,3)]
                            ]);

                            $images = Image::factory(mt_rand(2,4))->make();//se crean entre 2 y 4 imagenes para cada producto
                            $product->images()->saveMany($images);//se guardan en el producto las imágenes generadas
                        });

        $userJ = User::create([
            'name' => 'joshua',
            'email' => 'josh@gmail.com',
            'email_verified_at' => now(),
            'admin_since' => now(),
            'password' => Hash::make('hola1234'),
            'remember_token' => Str::random(10),
        ]);
        $imageJ = Image::factory()//se crea una image de tipo user
        ->userJ()
        ->make();
        $userJ->image()->save($imageJ);

    }
}

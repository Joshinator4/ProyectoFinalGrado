<?php
//!Este comando ha sido creado por medio de php artisan make:command nombreDelComando
//*Se pueden programar desde el archivo routes/console.php
namespace App\Console\Commands;

use App\Models\Cart;
use Illuminate\Console\Command;

class RemoveOldCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carts:remove-old-carts {--days=7 : The days after wich the carts will be remove}'; //*Este sera el nombre del comando en este caso se llamaria asi:
    //*php artisan carts:remove-old-carts (por defecto son 7 dias)   o   artisan carts:remove-old-carts --days=2 (se le puede pasar el parametro days para poner los dias que queramos)

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old carts from a given set of days.';

    /**
     * Execute the console command.
     */
    public function handle()//!Aqui se define la lógica del comando
    {
        $deadline = now()->subdays($this->option('days'));//Nos quedamos con la fecha de hoy y se le restan los dias pasado por el comando o 7 por defecto

        $counter = Cart::whereDate('updated_at', '<=', $deadline)->delete(); //Se  borran los carritos que sean anteriores a la fecha definida en $deadline

        $this->info("Done! {$counter} carts was removed.");//se muestra mensaje en consola
    }
}

<?php

//Este archivo se ha creado mediante el uso de php artisan make:migrate CreateProductsTable

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Se crea una estructura de id y timestamp automaticamente y yo le añado las comlumnas deseadas como title, description, price... etc
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 1000);
            $table->float('price')->unsigned();
            $table->integer('stock')->unsigned();
            $table->string('status')->default('unavailable');
            $table->softDeletes();//!este campo es para poder realizar el softdelete de este producto. No se elimina solo se oculta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

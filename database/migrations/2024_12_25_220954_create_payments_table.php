<?php

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount')->unsigned();
            $table->timestamp('payed_at')->nullable();
            $table->unsignedBigInteger('order_id')->unsigned();//esto es una clave foránea
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');//así se define la froeign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

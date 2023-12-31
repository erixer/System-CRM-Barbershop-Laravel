<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('order_produks')->onDelete('cascade');
            $table->foreignId('produk_id')->references('id')->on('produks')->onDelete('cascade');
            $table->integer('qty');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_produks');
    }
}

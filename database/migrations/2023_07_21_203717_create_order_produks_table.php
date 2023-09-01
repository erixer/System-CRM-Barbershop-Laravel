<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_produks', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('customer');
            $table->foreignId('payment_id');
            $table->integer('net');
            $table->integer('gross');
            $table->integer('total_duration');
            $table->enum('lunas', ['Order', 'Payment', 'Approved'])->default('Order');
            $table->text('note')->nullable();
            $table->string('images')->nullable();
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
        Schema::dropIfExists('order_produks');
    }
}

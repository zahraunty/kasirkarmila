<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('final_price', 15, 2);
            $table->decimal('total_price', 15, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     *  
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

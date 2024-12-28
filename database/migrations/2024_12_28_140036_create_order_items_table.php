<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
           
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Clé étrangère vers orders
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade'); // Clé étrangère vers items
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}

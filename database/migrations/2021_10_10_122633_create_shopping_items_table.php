<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("shopping_id");
            $table->unsignedBigInteger("product_id");
            $table->string('name',255);
            $table->string('code', 100)->nullable();
            $table->string('barcode', 120)->nullable();
            $table->float('price')->default(0.0);
            $table->integer('qyt')->default(1);

            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->foreign("shopping_id")->references("id")->on("shoppings")->onDelete('cascade');
            $table->foreign("product_id")->references("id")->on("products")->onDelete('cascade');

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
        Schema::dropIfExists('shopping_items');
    }
}

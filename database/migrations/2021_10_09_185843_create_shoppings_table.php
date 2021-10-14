<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();
            $table->integer("type")->default(1);
            $table->boolean("payed")->default(false);
            $table->string("shipping_address", 255)->nullable();
            $table->string("pay_type", 255)->default('cash');
            $table->string("qrcode", 255)->nullable();
            $table->string("barcode", 255)->nullable();

            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("customer_id");
            $table->unsignedBigInteger("location_id");
            $table->unsignedBigInteger("card_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->foreign("customer_id")->references("id")->on("customers")->onDelete('cascade');
            $table->foreign("location_id")->references("id")->on("locations")->onDelete('cascade');
            $table->foreign("card_id")->references("id")->on("cards")->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoppings');
    }
}

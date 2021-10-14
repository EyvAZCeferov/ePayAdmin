<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text("picture")->nullable();
            $table->json('names');
            $table->json('descriptors')->nullable();
            $table->string('code', 100)->nullable();
            $table->string('barcode', 120)->nullable();
            $table->json('category')->nullable();
            $table->float('price')->default(0.0);
            $table->integer('quantity')->default(1);
            $table->json('seo_urls');

            $table->unsignedBigInteger('customer_id');
            $table->foreign("customer_id")->references("id")->on("customers")->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
}

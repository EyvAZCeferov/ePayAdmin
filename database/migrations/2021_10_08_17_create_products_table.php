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
            $table->longText('names');
            $table->longText('descriptors')->nullable();
            $table->string('code', 100)->nullable();
            $table->string('barcode', 120)->nullable();
            $table->longText('category')->nullable();
            $table->float('price')->default(0.0);
            $table->longText('seo_urls');
            $table->boolean('enabled')->default(true);

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

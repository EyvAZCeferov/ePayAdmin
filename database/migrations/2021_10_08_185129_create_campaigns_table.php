<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->json("pictures")->nullable();
            $table->json("names");
            $table->json("descriptors")->nullable();
            $table->json("dates")->nullable();
            $table->json('seo_urls');
            $table->json("related_products")->nullable();
            $table->json("prices")->nullable();
            $table->boolean("notify")->default(false);

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
        Schema::dropIfExists('campaigns');
    }
}

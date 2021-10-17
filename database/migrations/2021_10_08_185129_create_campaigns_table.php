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
            $table->longText("pictures")->nullable();
            $table->longText("names");
            $table->longText("descriptors")->nullable();
            $table->longText("dates")->nullable();
            $table->longText('seo_urls');
            $table->longText("related_products")->nullable();
            $table->longText("prices")->nullable();
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

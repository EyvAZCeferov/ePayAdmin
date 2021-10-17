<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->longText("names");
            $table->string("address",255)->nullable();
            $table->longText("descriptors")->nullable();
            $table->longText("geolocations")->nullable();
            $table->longText("pictures")->nullable();

            $table->unsignedBigInteger("customers_id");
            $table->foreign("customers_id")->references("id")->on("customers")->onDelete('cascade');

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
        Schema::dropIfExists('locations');
    }
}

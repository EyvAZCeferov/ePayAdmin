<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string("logo",255)->nullable();
            $table->string("project_name",255)->default('ePay');
            $table->string("site_url",255)->default('https://epay.com.az');
            $table->string("site_admin_url",255)->default('https://zlimusu.epay.com.az');
            $table->json("site_descriptors");
            $table->json("social_media");
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
        Schema::dropIfExists('settings');
    }
}

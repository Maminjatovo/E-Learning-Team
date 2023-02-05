<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ensignants', function (Blueprint $table) {
            $table->id("id_ens");
            $table->string("nom_ens");
            $table->string("prenom_ens");
            $table->string("adresse_ens");
            $table->string("telephone_ens");
            $table->string("email_ens");
            $table->string("photo_ens");
            $table->string("specialite_ens");
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
        Schema::dropIfExists('ensignants');
    }
};

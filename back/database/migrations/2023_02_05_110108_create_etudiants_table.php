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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id('id_etu');
            $table->timestamps();
            $table->string("nom_etu")->nullable();
            $table->string("prenom_etu")->nullable();
            $table->string("adresse_etu")->nullable();
            $table->string("telephone_etu")->nullable();
            $table->string("email_etu")->nullable();
            $table->string("photo_etu")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
};

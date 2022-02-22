<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->index();
            $table->unsignedBigInteger('livreur_id')->index()->nullable();
            $table->string('ship_nom');
            $table->string('ship_prenom');
            $table->text('shipadresse');
            $table->string('ship_ville');
            $table->string('ship_region');
            $table->integer('ship_code_postal')->nullable();
            $table->string('ship_pays')->default("Maroc");
            $table->string('ship_phone');
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('livreur_id')->references('id')->on('livreurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commandes');
    }
}

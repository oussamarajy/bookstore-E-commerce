<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('auteur_id')->index();
            $table->unsignedBigInteger('categorie_id')->index();
            $table->bigInteger('quantity');
            $table->integer('isbn')->unique();
            $table->double('prix');
            $table->integer('nb_pages')->nullable();
            $table->date('date_pub')->nullable();
            $table->text('image');
            $table->timestamps();

            $table->foreign('auteur_id')->references('id')->on('auteurs')->onDelete('cascade');
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livres');
    }
}

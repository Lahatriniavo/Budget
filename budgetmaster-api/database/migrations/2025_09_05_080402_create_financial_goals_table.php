<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialGoalsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_goals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // lien vers utilisateur
            $table->string('name');
            $table->decimal('target_amount', 15, 2);  // montant objectif
            $table->date('deadline')->nullable();  // date limite (optionnel)
            $table->string('category')->nullable(); // catégorie (Logement, Transport, etc)
            $table->decimal('saved_amount', 15, 2)->default(0);  // montant déjà épargné
            $table->timestamps();

            // Foreign key vers table users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_goals');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table des tirages
        Schema::create('draws', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->json('numbers');
            $table->json('stars');
            $table->decimal('jackpot', 15, 2)->default(3000000);
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });

        // Table des tickets de participation
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('draw_id')->constrained()->onDelete('cascade');
            $table->json('numbers');
            $table->json('stars');
            $table->timestamps();
        });

        // Table de la répartition des gains
        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draw_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('rank');
            $table->decimal('amount', 15, 2);
            $table->integer('percentage');
            $table->timestamps();
        });

        // Table des cagnottes
        Schema::create('jackpots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draw_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('jackpots');
        Schema::dropIfExists('prizes');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('draws');
    }
};

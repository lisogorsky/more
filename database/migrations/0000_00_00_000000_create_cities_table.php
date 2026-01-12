<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // название города
            $table->string('district')->nullable();  // округ
            $table->string('subject')->nullable();   // субъект РФ (область/край/республика)
            $table->integer('population')->nullable(); // население
            $table->decimal('lat', 10, 6)->nullable(); // широта
            $table->decimal('lon', 10, 6)->nullable(); // долгота
            $table->string('slug')->unique();
            $table->uuid('fias_id')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};

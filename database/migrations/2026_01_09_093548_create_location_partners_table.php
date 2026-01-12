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
        Schema::create('location_partners', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->foreignId('city_id')->constrained();
            $table->string('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->text('description')->nullable();

            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->foreignId('partner_id')->constrained();
            $table->foreignId('category_partner_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_partners');
    }
};

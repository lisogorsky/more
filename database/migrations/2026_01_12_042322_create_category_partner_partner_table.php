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
        Schema::create('category_partner_partner', function (Blueprint $table) {
            $table->id();
            // Внешний ключ на категорию
            $table->foreignId('category_partner_id')
                ->constrained('category_partners')
                ->onDelete('cascade');

            // Внешний ключ на партнера
            $table->foreignId('partner_id')
                ->constrained('partners')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_partner_partner');
    }
};

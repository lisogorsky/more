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
        Schema::create('category_partner_event', function (Blueprint $table) {
            $table->id();

            // Связь с таблицей events
            $table->foreignId('event_id')
                ->constrained()
                ->onDelete('cascade');

            // Связь с таблицей category_partners
            $table->foreignId('category_partner_id')
                ->constrained('category_partners') // Указываем имя таблицы явно
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_partner_event');
    }
};

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
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->unique();

            // Основные данные
            $table->string('name');
            $table->string('public_slug')->unique();
            $table->text('description')->nullable();

            // Медиа
            $table->string('logo')->nullable();
            $table->string('cover')->nullable();

            // Контакты
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();

            // Соцсети
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();

            // Статус
            $table->boolean('is_active')->default(true);

            //Модерация
            $table->boolean('is_moderated')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizers');
    }
};

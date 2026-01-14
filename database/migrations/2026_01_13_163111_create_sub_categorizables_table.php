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
        Schema::create('sub_categorizables', function (Blueprint $table) {
            $table->id();

            // ID подкатегории (связь с таблицей sub_categories)
            $table->foreignId('sub_category_id')
                ->constrained()
                ->onDelete('cascade');

            // Поля для полиморфизма: sub_categorizable_id и sub_categorizable_type
            // Это позволит привязывать как Organizer (id), так и Participant (id)
            $table->morphs('sub_categorizable');

            // Опционально: индекс для ускорения выборки (уже включен в morphs)
            // Но можно добавить уникальный индекс, чтобы нельзя было привязать одну 
            // и ту же подкатегорию одному юзеру дважды
            $table->unique([
                'sub_category_id',
                'sub_categorizable_id',
                'sub_categorizable_type'
            ], 'sub_cat_unique_index');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categorizables');
    }
};

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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->string('slug');
            $table->string('address');

            $table->date('date_start');
            $table->date('date_end');


            $table->time('time_start')->after('date_start');
            $table->time('time_end')->after('date_end')->nullable();

            $table->integer('duration_minutes')->nullable();

            $table->decimal('price', 10, 2);
            $table->boolean('price_from')->default(false);
            $table->boolean('has_discount')->default(false);
            $table->enum('discount_type', ['percent', 'amount'])->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();

            $table->integer('max_participants')->nullable();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            $table->foreignId('category_id')->constrained();
            $table->foreignId('sub_category_id')->constrained();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->foreignId('organizer_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

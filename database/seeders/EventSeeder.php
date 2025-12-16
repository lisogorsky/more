<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Image;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $images = Storage::disk('public')->files('event');

        if (empty($images)) {
            $this->command->error('❌ Нет изображений в storage/app/public/event');
            return;
        }


        $userIds = User::pluck('id');
        $subCategories = SubCategory::all();

        foreach ($subCategories as $subCategory) {
            for ($i = 1; $i <= 3; $i++) {

                $name = $subCategory->name . ' — событие ' . $i;

                $event = Event::create([
                    'name' => $name,
                    'description' => 'Описание события: ' . $name,
                    'slug' => Str::slug($name) . '-' . uniqid(),
                    'address' => 'Город, ул. Примерная, 1',
                    'date_start' => now()->addDays(rand(1, 10)),
                    'date_end' => now()->addDays(rand(11, 20)),
                    'time_start' => now()->addHours(rand(1, 10)),
                    'time_end' => now()->addHours(rand(11, 20)),
                    'duration_minutes' => rand(30, 120),
                    'price' => rand(0, 12000),
                    'limit' => rand(10, 50),
                    'seo_title' => $name,
                    'seo_description' => 'SEO описание: ' . $name,
                    'category_id' => $subCategory->category_id,
                    'sub_category_id' => $subCategory->id,
                    'user_id' => $userIds->random(),
                ]);

                // 1–4 изображения
                collect($images)->random(rand(1, 4))->each(function ($path, $index) use ($event) {
                    Image::create([
                        'path' => $path,
                        'alt' => $event->name,
                        'title' => $event->name,
                        'sort' => $index,
                        'event_id' => $event->id,
                    ]);
                });
            }
        }

        $this->command->info('✅ Events + Images созданы');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $comments = [
            'Отличное событие, много полезной информации.',
            'Понравилась организация и подача материала.',
            'Интересные кейсы и практические примеры.',
            'Хороший уровень докладов.',
            'Полезно и информативно.',
            'В целом всё понравилось.',
            'Можно было глубже раскрыть тему.',
            'Неплохое событие, но ожидал большего.',
            'Отличный формат и сильные спикеры.',
        ];

        $users = User::all();

        Event::query()->each(function ($event) use ($users, $comments) {

            if ($users->isEmpty()) {
                return;
            }

            // Сколько отзывов будет у события
            $reviewsCount = rand(2, min(8, $users->count()));

            $usedUsers = $users->random($reviewsCount);

            foreach ($usedUsers as $user) {

                Review::create([
                    'event_id'   => $event->id,
                    'user_id'    => $user->id,
                    'rating'     => rand(3, 5),
                    'review'    => Arr::random($comments),
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}

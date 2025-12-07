<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\City;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ru_RU'); // русифицированные имена и фамилии

        // Получаем роли и города
        $roles = Role::all();
        $cities = City::all();

        // Папка с аватарками
        $avatarsDir = storage_path('app/public/people');
        $avatars = glob($avatarsDir . '/*.{jpg,jpeg,png}', GLOB_BRACE);

        for ($i = 1; $i <= 100; $i++) {
            // Случайный город
            $city = $cities->random();

            // Случайный аватар
            $avatarPath = $avatars ? $avatars[array_rand($avatars)] : null;
            if ($avatarPath) {
                // Преобразуем путь для фронта
                $avatar = 'storage/people/' . basename($avatarPath);
            } else {
                $avatar = null;
            }

            // Создаём пользователя
            $user = User::create([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'bio' => $faker->sentence,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'avatar' => $avatar,
                'password' => Hash::make('password123'),
                'city_id' => $city->id,
            ]);

            // Назначаем от 1 до 3 ролей случайным образом
            $assignedRoles = $roles->random(rand(1, 3))->pluck('id')->toArray();
            $user->roles()->sync($assignedRoles);
        }

        $this->command->info('✅ 100 пользователей с городами, ролями и аватарками успешно созданы!');
    }
}

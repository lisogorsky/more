<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\City;
use App\Models\Organizer;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ru_RU');

        $roles = Role::all();
        $cities = City::all();

        // Папка с аватарками
        $avatarsDir = storage_path('app/public/people');
        $avatars = glob($avatarsDir . '/*.{jpg,jpeg,png}', GLOB_BRACE);

        for ($i = 1; $i <= 100; $i++) {
            $city = $cities->random();

            $avatarPath = $avatars ? $avatars[array_rand($avatars)] : null;
            $avatar = $avatarPath ? 'storage/people/' . basename($avatarPath) : null;

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

            // Если пользователь – организатор (роль с id = 2)
            if (in_array(2, $assignedRoles)) {
                Organizer::create([
                    'user_id' => $user->id,
                    'name' => $user->name . ' ' . $user->surname,
                    'public_slug' => Str::slug($user->name . '-' . $user->surname) . '-' . uniqid(),
                    'description' => $faker->paragraph,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'logo' => $avatar,
                    'cover' => null,
                    'instagram' => null,
                    'telegram' => null,
                    'meta_title' => $user->name . ' ' . $user->surname,
                    'meta_description' => $faker->sentence,
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('✅ 100 пользователей с ролями и организаторов успешно созданы!');
    }
}

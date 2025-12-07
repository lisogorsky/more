<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Убедись, что есть модель Role

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Участник',
            'Организатор',
            'Партнер',
        ];

        foreach ($roles as $roleName) {
            \App\Models\Role::updateOrCreate(
                ['name' => $roleName],
                ['name' => $roleName]
            );
        }

        $this->command->info('Роли успешно созданы!');
    }
}

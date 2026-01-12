<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CitiesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(Category_SubcategorySeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(CategoryPartnerSeeder::class);
    }
}

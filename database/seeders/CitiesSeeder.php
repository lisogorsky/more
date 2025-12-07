<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use Illuminate\Support\Str;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        // Путь к JSON-файлу с городами
        $jsonPath = storage_path('app/public/city/russian-cities.json');

        if (!file_exists($jsonPath)) {
            $this->command->error("Файл городов не найден: $jsonPath");
            return;
        }

        $json = file_get_contents($jsonPath);
        $cities = json_decode($json, true);

        if (!$cities) {
            $this->command->error("Не удалось декодировать JSON");
            return;
        }

        foreach ($cities as $cityData) {
            City::updateOrCreate(
                ['name' => $cityData['name']], // уникальность по имени
                [
                    'slug'       => \Illuminate\Support\Str::slug($cityData['name']),
                    'district'   => $cityData['district'] ?? null,
                    'subject'    => $cityData['subject'] ?? null,
                    'population' => $cityData['population'] ?? null,
                    'lat'        => isset($cityData['coords']['lat']) ? (float)$cityData['coords']['lat'] : null,
                    'lon'        => isset($cityData['coords']['lon']) ? (float)$cityData['coords']['lon'] : null,
                ]
            );
        }
    }
}

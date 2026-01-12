<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DadataService
{
    protected string $baseUrl = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs';

    protected function client()
    {
        return Http::withHeaders([
            'Authorization' => 'Token ' . config('services.dadata.token'),
            'X-Secret'      => config('services.dadata.secret'),
            'Accept'        => 'application/json',
        ]);
    }

    public function suggestAddress(string $query, int $count = 5, ?string $fiasId = null): array
    {

        $params = [
            'query' => $query,
            'count' => $count,
            // Указываем, что искать нужно от уровня улицы и ниже (улица, дом)
            'from_bound' => ['value' => 'street'],
            'to_bound'   => ['value' => 'house'],
            // Ограничиваем выдачу только тем, что попало в фильтр (убирает лишние города)
            'restrict_value' => true,
        ];

        if ($fiasId) {
            $params['locations'] = [
                ['city_fias_id' => $fiasId]
            ];
        }

        $response = $this->client()->post(
            $this->baseUrl . '/suggest/address',
            $params
        );

        return $response->json('suggestions') ?? [];
    }

    public function suggestParty(string $query): array
    {
        $response = $this->client()->post(
            $this->baseUrl . '/suggest/party',
            ['query' => $query]
        );

        return $response->json('suggestions') ?? [];
    }

    public function getCityFias(string $cityName): ?array
    {
        $response = $this->client()->post($this->baseUrl . '/suggest/address', [
            'query' => $cityName,
            'count' => 1,
            'from_bound' => ['value' => 'city'],
            'to_bound'   => ['value' => 'city'], // Ищем строго город
        ]);

        $data = $response->json('suggestions.0.data');

        if (!$data) return null;

        return [
            'fias_id' => $data['city_fias_id'] ?? $data['fias_id'],
            'lat' => $data['geo_lat'],
            'lon' => $data['geo_lon'],
        ];
    }
}

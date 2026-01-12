<?php

namespace App\Livewire\City;

use Livewire\Component;
use App\Models\City;
use App\Services\DadataService;
use App\Livewire\Event\EventCreate;

class AddressSuggest extends Component
{
    public string $query = '';
    public array $suggestions = [];
    public bool $selected = false;
    public ?int $cityId = null; // id выбранного города

    protected $listeners = ['citySelected' => 'onCitySelected'];

    public function onCitySelected(int $cityId)
    {
        $this->cityId = $cityId;
        $this->query = '';
        $this->suggestions = [];
    }

    public function updatedQuery(DadataService $dadata)
    {
        if (!$this->cityId || mb_strlen($this->query) < 3) {
            $this->suggestions = [];
            return;
        }

        $city = City::find($this->cityId);

        // Если FIAS нет, получаем его СТРОГО как город
        if (!$city->fias_id) {
            $cityData = $dadata->getCityFias($city->name);

            if ($cityData) {
                $city->update([
                    'fias_id' => $cityData['fias_id'],
                    'lat' => $cityData['lat'],
                    'lon' => $cityData['lon'],
                ]);
                // Обновляем модель в текущем процессе
                $city->refresh();
            }
        }

        // Теперь поиск будет идти СТРОГО внутри этого FIAS
        $this->suggestions = $dadata->suggestAddress(
            query: $this->query,
            fiasId: $city->fias_id
        );
    }

    public function select(string $value)
    {
        $this->query = $value;
        $this->suggestions = [];
        $this->selected = true;
        // Отправляем событие наверх родителю
        $this->dispatch('addressUpdated', address: $value)->to(EventCreate::class);
    }

    public function render()
    {
        return view('livewire.city.address-suggest');
    }
}

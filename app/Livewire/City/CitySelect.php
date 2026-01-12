<?php

namespace App\Livewire\City;

use Livewire\Component;
use App\Models\City;

class CitySelect extends Component
{
    public $query = '';
    public $selectedCity = null;
    public $results = [];

    public function updatedQuery()
    {

        $this->results = City::where('name', 'ILIKE', "%{$this->query}%")
            ->orderBy('name')
            ->limit(10)
            ->get();
    }

    public function selectCity($cityId)
    {
        $this->selectedCity = City::find($cityId);

        if ($this->selectedCity) {
            $this->query = $this->selectedCity->name;
            $this->results = [];

            // В Livewire v3 передаем параметры вот так:
            $this->dispatch('citySelected', cityId: $this->selectedCity->id);
        }
    }
    public function render()
    {
        return view('livewire.city.city-select');
    }
}

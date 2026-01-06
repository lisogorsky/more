<?php

namespace App\Livewire\Cabinet;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CabinetSwitcher extends Component
{

    public $activeCabinet;
    public $cabinets = [];

    public function mount()
    {
        // Делаем всегда коллекцию, даже если у пользователя нет кабинетов
        $this->cabinets = Auth::user()->roles ?? collect();

        // Безопасно берем первый кабинет, если коллекция не пустая
        $this->activeCabinet = session('active_cabinet') ?? ($this->cabinets->first()?->id ?? null);
    }

    public function switchCabinet($cabinetId)
    {
        if (Auth::user()->roles->contains('id', $cabinetId)) {
            $this->activeCabinet = $cabinetId;
            session(['active_cabinet' => $cabinetId]);
            $this->dispatch('cabinetSwitched');

            // Определяем маршрут по типу кабинета
            $route = match ($cabinetId) {
                // Предположим, что у роли есть поле 'type' => 'organizer'|'participant'|'partner'
                'organizer' => route('cabinet.organizer'),
                'participant' => route('cabinet.participant'),
                'partner' => route('cabinet.partner'),
                default => route('cabinet.participant'),
            };

            return redirect($route);
        }
    }


    public function render()
    {
        return view('livewire.cabinet.cabinet-switcher');
    }
}

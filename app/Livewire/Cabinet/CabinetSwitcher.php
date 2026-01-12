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

    public function switchCabinet($value)
    {
        // 1. Проверяем, не выбрал ли пользователь пункт "Настройки"
        if ($value === 'go_to_settings') {
            return redirect()->route('dashboard');
        }

        // 2. Если это ID роли, приводим к числу для надежности
        $cabinetId = (int) $value;

        // 3. Проверяем, есть ли у пользователя такая роль
        if (Auth::user()->roles->contains('id', $cabinetId)) {

            // Сохраняем в сессию и обновляем свойство
            $this->activeCabinet = $cabinetId;
            session(['active_cabinet' => $cabinetId]);

            // Сообщаем другим компонентам (если они не используют редирект)
            $this->dispatch('cabinetSwitched');

            // 4. Определяем маршрут (используем строковые ключи для match, так как ID пришли из селекта)
            $route = match ($cabinetId) {
                2 => route('cabinet.organizer'),
                1 => route('cabinet.participant'),
                3 => route('cabinet.partner'),
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

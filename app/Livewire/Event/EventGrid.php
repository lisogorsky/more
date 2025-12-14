<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\On;

class EventGrid extends Component
{
    public string $view = 'grid';
    public int $amount = 12; // Сколько всего записей отображать

    // В Livewire 3 лучше передавать данные в render, 
    // чтобы избежать проблем с сериализацией больших коллекций в public свойствах
    public function render()
    {
        $events = Event::with(['images', 'category', 'subCategory'])
            ->latest()
            ->take($this->amount)
            ->get();

        return view('livewire.event.event-grid', [
            'events' => $events
        ]);
    }

    #[On('change-view')]
    public function changeView($view)
    {
        $this->view = $view;
    }

    // Этот метод вызывается из Alpine.js при скролле
    public function loadMore()
    {
        $this->amount += 12;

        // Отправляем браузеру сигнал, что загрузка окончена
        $this->dispatch('loaded');
    }
}

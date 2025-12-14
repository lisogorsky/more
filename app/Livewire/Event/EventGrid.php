<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;

class EventGrid extends Component
{
    public string $view = 'grid';
    public int $amount = 12;

    public function render()
    {
        $cacheKey = "events:grid:latest:amount:{$this->amount}";

        $events = Cache::remember($cacheKey, now()->addMinutes(5), function () {
            return Event::with(['images', 'category', 'subCategory'])
                ->latest()
                ->take($this->amount)
                ->get();
        });

        return view('livewire.event.event-grid', [
            'events' => $events
        ]);
    }

    #[On('change-view')]
    public function changeView(string $view)
    {
        $this->view = $view;
    }

    public function loadMore()
    {
        $this->amount += 12;
        $this->dispatch('loaded');
    }
}

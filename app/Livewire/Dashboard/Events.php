<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class Events extends Component
{
    public $upcomingEvents = [];
    public $completedEvents = [];

    public function mount()
    {
        $organizer = Auth::user()->organizer;

        $this->upcomingEvents = Event::where('organizer_id', $organizer->id)
            ->whereRaw("(date_start + time_start) >= ?", [now()])
            ->orderByRaw("(date_start + time_start) ASC")
            ->get();

        $this->completedEvents = Event::where('organizer_id', $organizer->id)
            ->whereRaw("(date_start + time_start) < ?", [now()])
            ->orderByRaw("(date_start + time_start) DESC")
            ->get();
    }


    public function render()
    {
        return view('livewire.dashboard.events');
    }
}

<?php

namespace App\Livewire\EventOrganizers;

use Livewire\Component;
use App\Models\User;

class EventOrganizersGrid extends Component
{
    public function render()
    {
        $organizers = User::query()
            ->whereHas('roles', function ($q) {
                $q->where('roles.id', 2); // Я Организатор
            })
            ->limit(8)
            ->get();

        return view('livewire.event-organizers.event-organizers-grid', [
            'organizers' => $organizers
        ])->layout('layouts.app');
    }
}

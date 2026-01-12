<?php

namespace App\Livewire\Cabinet;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OrganizerCabinet extends Component
{
    public string $tab = 'events';
    public string $cabinet = 'organizer';

    protected $queryString = ['tab'];

    public function setTab(string $tab)
    {
        $this->tab = $tab;
    }
    public function render()
    {
        return view('livewire.cabinet.organizer-cabinet', ['cabinet' => $this->cabinet,])->layout('layouts.app');
    }
}

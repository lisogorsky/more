<?php

namespace App\Livewire\Cabinet;

use Livewire\Component;

class ParticipantCabinet extends Component
{
    public string $tab = 'bookings';
    public string $cabinet = 'participant';

    protected $queryString = ['tab'];

    public function setTab(string $tab)
    {
        $this->tab = $tab;
    }


    public function render()
    {
        return view('livewire.cabinet.participant-cabinet', ['cabinet' => $this->cabinet,])->layout('layouts.app');
    }
}

<?php

namespace App\Livewire\Cabinet;

use Livewire\Component;

class PartnerCabinet extends Component
{
    public string $tab = 'bookings';
    public string $cabinet = 'partner';

    protected $queryString = ['tab'];

    public function setTab(string $tab)
    {
        $this->tab = $tab;
    }

    public function render()
    {
        return view('livewire.cabinet.partner-cabinet', ['cabinet' => $this->cabinet,])->layout('layouts.app');
    }
}

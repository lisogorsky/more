<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;


class Index extends Component
{
    public string $tab = 'settings';

    protected $queryString = ['tab'];

    public function setTab(string $tab)
    {
        $this->tab = $tab;
    }

    public function render()
    {
        return view('livewire.dashboard.index')->layout('layouts.app');
    }
}

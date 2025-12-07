<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;


class Index extends Component
{
    protected string $layout = 'layouts.app';

    public function render()
    {
        return view('livewire.dashboard.index')->layout('layouts.app');
    }
}

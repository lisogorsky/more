<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Role;

class Settings extends Component
{

    public int|null $roleId = null;

    public function addRole()
    {
        $this->validate([
            'roleId' => 'required|exists:roles,id',
        ]);

        $user = auth()->user();

        // не добавлять дубликат
        if (! $user->roles()->where('roles.id', $this->roleId)->exists()) {
            $user->roles()->attach($this->roleId);
        }

        $this->reset('roleId');
    }

    public function removeRole(int $roleId)
    {
        auth()->user()->roles()->detach($roleId);
    }


    public function render()
    {
        return view('livewire.dashboard.settings', [
            'roles' => Role::all(),
        ]);
    }
}

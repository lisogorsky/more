<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Role;
use App\Models\Organizer;
use App\Models\Partner;
use App\Models\Participant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Settings extends Component
{
    public int|null $roleId = null;

    public function addRole()
    {
        $this->validate([
            'roleId' => 'required|exists:roles,id',
        ]);

        $user = auth()->user();

        DB::transaction(function () use ($user) {
            if (!$user->roles()->where('roles.id', $this->roleId)->exists()) {
                $user->roles()->attach($this->roleId);
            }

            match ((int)$this->roleId) {
                1 => $this->createParticipantProfile($user),
                2 => $this->createOrganizerProfile($user),
                3 => $this->createPartnerProfile($user),
                default => null,
            };
        });

        $this->reset('roleId');
    }

    // Добавили этот метод, которого не хватало
    protected function createParticipantProfile($user)
    {
        if (!$user->participant) {
            $user->participant()->create([
                // Если в таблице participants нет обязательных полей, 
                // оставляем массив пустым
            ]);
        }
    }

    protected function createOrganizerProfile($user)
    {
        if (!$user->organizer) {
            $baseSlug = Str::slug($user->name ?: 'organizer-' . $user->id);
            $slug = $baseSlug;
            $i = 1;
            while (Organizer::where('public_slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }

            $user->organizer()->create([
                'name'         => $user->name ?? 'Организатор',
                'public_slug'  => $slug,
                'is_active'    => true,
                'is_moderated' => true,
            ]);
        }
    }

    protected function createPartnerProfile($user)
    {
        if (!$user->partner) {
            $user->partner()->create([
                'company_name'      => $user->name ?? 'Новый партнер',
                'public_slug'       => Str::slug($user->name ?: 'partner-' . $user->id),
                'is_active' => true,
            ]);
        }
    }

    public function removeRole(int $roleId): void
    {
        $user = auth()->user();

        DB::transaction(function () use ($user, $roleId) {
            $user->roles()->detach($roleId);

            match ((int)$roleId) {
                1 => $user->participant()?->delete(),
                2 => $user->organizer()?->delete(),
                3 => $user->partner()?->delete(),
                default => null,
            };

            if (session('active_cabinet') == $roleId) {
                session()->forget('active_cabinet');
            }
        });
    }

    public function render()
    {
        return view('livewire.dashboard.settings', [
            'roles' => Role::all(),
        ]);
    }
}

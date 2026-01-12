<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;


class Profile extends Component
{
    use WithFileUploads;

    public $user;
    public $profile;
    public $activeRole;

    public $photo;

    protected function rules()
    {
        return [
            'profile.name' => 'nullable|string|max:255',
            'profile.description' => 'nullable|string',
            'profile.public_slug' => 'nullable|string',
            'profile.company_name' => 'nullable|string',
            'profile.inn' => 'nullable|string',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->activeRole = (int) session('active_cabinet');

        $model = match ($this->activeRole) {
            1 => $this->user->participant,
            2 => $this->user->organizer,
            3 => $this->user->partner,
            default => null,
        };

        $this->profile = $model?->toArray();
    }


    public function save()
    {
        //  dd($this->all());
        $this->validate();

        $model = match ($this->activeRole) {
            1 => $this->user->participant,
            2 => $this->user->organizer,
            3 => $this->user->partner,
        };

        // 1️⃣ Сохраняем фото
        if ($this->photo) {

            [$folder, $field] = match ($this->activeRole) {
                1 => ['participants', 'avatar'],
                2 => ['organizers', 'logo'],
                3 => ['partners', 'logo'],
            };

            // (опционально) удалить старое фото
            if (!empty($model->{$field})) {
                \Storage::disk('public')->delete($model->{$field});
            }

            $path = $this->photo->store("media/{$folder}", 'public');
            $this->profile[$field] = $path;
        }

        // 2️⃣ Сохраняем остальные поля
        $model->fill($this->profile);
        $model->save();

        // 3️⃣ ОБЯЗАТЕЛЬНО очистить временный файл
        $this->photo = null;

        session()->flash('success', 'Профиль обновлен!');
    }
    public function render()
    {
        return view('livewire.dashboard.profile');
    }
}

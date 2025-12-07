<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class ForgotPasswordModal extends Component
{
    public $showModal = false;

    public $mode = 'send'; // send | verify | reset

    public $identifier; // phone OR email
    public $code;
    public $newPassword;
    public $newPassword_confirmation;

    public $userId;

    protected $listeners = [
        'show-forgot-password-modal' => 'openModal'
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->mode = 'send';
        $this->identifier = '';
        $this->code = '';
        $this->newPassword = '';
        $this->newPassword_confirmation = '';
    }

    /**
     * Шаг 1 — отправка кода
     */
    public function sendCode()
    {
        $this->validate([
            'identifier' => 'required|string'
        ]);

        $user = User::where('phone', $this->identifier)
            ->orWhere('email', $this->identifier)
            ->first();

        if (!$user) {
            return $this->addError('identifier', 'Пользователь не найден');
        }

        $this->userId = $user->id;

        //$code = rand(1000, 9999);
        $code = 1234; // для тестов

        Cache::put("forgot_code:{$user->id}", $code, 300);

        // здесь можно добавить отправку SMS / email
        // SmsService::send($user->phone, "Код для восстановления: $code");

        session()->flash('success', 'Код отправлен.');

        $this->mode = 'verify';
    }

    /**
     * Шаг 2 — проверка кода
     */
    public function verifyCode()
    {
        $this->validate([
            'code' => 'required'
        ]);

        $realCode = Cache::get("forgot_code:{$this->userId}");

        if (!$realCode || $realCode != $this->code) {
            return $this->addError('code', 'Неверный или истёкший код');
        }

        $this->mode = 'reset';
    }

    /**
     * Шаг 3 — сброс пароля
     */
    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:6|same:newPassword_confirmation'
        ]);

        $user = User::find($this->userId);

        if (!$user) {
            session()->flash('error', 'Ошибка сброса.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->newPassword)
        ]);

        Cache::forget("forgot_code:{$this->userId}");

        session()->flash('success', 'Пароль успешно обновлен!');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.auth.forgot-password-modal');
    }
}

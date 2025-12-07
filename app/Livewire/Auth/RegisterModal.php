<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;

class RegisterModal extends Component
{
    public $showModal = false;

    public $mode = 'input'; // input | verify | login

    public $phone;
    public $password;
    public $password_confirmation;
    public $code;
    public $role; // organizer | participant | partner
    public $loginPhone;
    public $loginPassword;


    #[On('show-register-modal')]
    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    #[On('close-register-modal')]
    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->phone = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->code = '';
        $this->mode = 'input';
    }

    // Шаг 1: ввод телефона + пароля
    public function startRegister()
    {
        $this->validate([
            'role' => 'required|exists:roles,id',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|same:password_confirmation',
            'password_confirmation' => 'required',
        ]);

        //$code = rand(1000, 9999);
        $code = 1234;

        // Сохраняем данные регистрации временно в Redis
        Cache::put("reg_data:{$this->phone}", [
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'role_id' => $this->role,
        ], 600); // 10 минут

        // Сохраняем SMS-код
        Cache::put("sms_code:{$this->phone}", $code, 300); // 5 минут

        // Телефон пока не подтверждён
        Cache::put("verified_phone:{$this->phone}", false, 600);

        // Тут можно интегрировать реальную отправку SMS
        // SmsService::send($this->phone, "Ваш код: $code");

        $this->mode = 'verify';
        session()->flash('success', 'Код отправлен на телефон!');
    }

    // Шаг 2: проверка SMS-кода
    public function verifyCode()
    {
        $this->validate([
            'code' => 'required',
        ]);

        $realCode = Cache::get("sms_code:{$this->phone}");

        if (!$realCode || $realCode != $this->code) {
            return $this->addError('code', 'Неверный или истекший код');
        }

        Cache::put("verified_phone:{$this->phone}", true, 600);

        $regData = Cache::get("reg_data:{$this->phone}");

        if (!$regData) {
            session()->flash('error', 'Данные регистрации истекли.');
            $this->closeModal();
            return;
        }

        // Создаём пользователя
        $user = User::create([
            'phone' => $regData['phone'],
            'password' => $regData['password'],
        ]);
        $user->roles()->attach($regData['role_id']);

        Auth::login($user);

        // Чистим Redis
        Cache::forget("reg_data:{$this->phone}");
        Cache::forget("sms_code:{$this->phone}");
        Cache::forget("verified_phone:{$this->phone}");

        session()->flash('success', 'Регистрация успешно завершена!');

        $this->closeModal();

        return redirect()->route('dashboard');
    }

    public function login()
    {
        $this->validate([
            'loginPhone' => 'required',
            'loginPassword' => 'required',
        ]);

        if (Auth::attempt(['phone' => $this->loginPhone, 'password' => $this->loginPassword])) {
            session()->regenerate();
            return redirect('/dashboard');
        } else {
            $this->addError('loginPhone', 'Неверный телефон или пароль');
        }
    }

    public function render()
    {
        return view('livewire.auth.register-modal');
    }
}

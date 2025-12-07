<div>
    <!-- Modal -->
    <div class="modal fade @if ($showModal) show @endif" tabindex="-1"
        @if ($showModal) style="display: block;" @endif>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($mode === 'verify')
                            Подтверждение кода
                        @elseif($mode === 'login')
                            Вход
                        @else
                            Регистрация
                        @endif
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>

                <!-- Switch buttons -->
                @if ($mode !== 'verify')
                    <div class="d-flex justify-content-center my-3">
                        <button class="btn btn-outline-primary me-2 @if ($mode === 'input') active @endif"
                            wire:click="$set('mode','input')">Регистрация</button>
                        <button class="btn btn-outline-success @if ($mode === 'login') active @endif"
                            wire:click="$set('mode','login')">Вход</button>
                    </div>
                @endif

                <!-- Body -->
                <div class="modal-body">

                    <!-- Регистрация -->
                    @if ($mode === 'input')
                        <form wire:submit.prevent="startRegister" class="d-flex flex-column gap-3">
                            <select wire:model.defer="role" class="form-select">
                                <option value="">Выберите роль</option>
                                @foreach (\App\Models\Role::all() as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                            <input wire:model.defer="phone" type="text" placeholder="Телефон" class="form-control">
                            @error('phone')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <input wire:model.defer="password" type="password" placeholder="Пароль"
                                class="form-control">
                            <input wire:model.defer="password_confirmation" type="password" placeholder="Повтор"
                                class="form-control">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-primary w-100">Отправить код</button>
                        </form>
                    @endif

                    <!-- Верификация кода -->
                    @if ($mode === 'verify')
                        <form wire:submit.prevent="verifyCode" class="d-flex flex-column gap-3">
                            <input wire:model.defer="code" type="text" placeholder="Код из SMS" class="form-control">
                            @error('code')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-success w-100">Подтвердить</button>
                        </form>
                    @endif

                    <!-- Авторизация -->
                    @if ($mode === 'login')
                        <form wire:submit.prevent="login" class="d-flex flex-column gap-3">
                            <input wire:model.defer="loginPhone" type="text" placeholder="Телефон"
                                class="form-control">
                            <input wire:model.defer="loginPassword" type="password" placeholder="Пароль"
                                class="form-control">
                            @error('loginPhone')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            @error('loginPassword')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-success w-100">Войти</button>
                        </form>
                    @endif

                    <button class="text-blue-600"
                        wire:click="
            $dispatch('close-register-modal');
            $dispatch('show-forgot-password-modal');
        ">
                        Забыли пароль?
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>

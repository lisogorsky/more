<div>
    @if ($showModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg rounded-3">

                    {{-- Header --}}
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">
                            @if ($mode === 'send')
                                Восстановление пароля
                            @endif
                            @if ($mode === 'verify')
                                Подтверждение
                            @endif
                            @if ($mode === 'reset')
                                Новый пароль
                            @endif
                        </h5>

                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body">

                        {{-- Шаг 1: отправка кода --}}
                        @if ($mode === 'send')
                            <div class="mb-3">
                                <label class="form-label">Телефон или Email</label>
                                <input type="text" wire:model="identifier" class="form-control"
                                    placeholder="Введите телефон или email">
                                @error('identifier')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button wire:click="sendCode" class="btn btn-primary w-100">
                                Отправить код
                            </button>
                        @endif

                        {{-- Шаг 2: ввод кода --}}
                        @if ($mode === 'verify')
                            <div class="mb-3">
                                <label class="form-label">Код подтверждения</label>
                                <input type="text" wire:model="code" class="form-control"
                                    placeholder="Код из SMS или Email">
                                @error('code')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button wire:click="verifyCode" class="btn btn-primary w-100">
                                Подтвердить
                            </button>
                        @endif

                        {{-- Шаг 3: новый пароль --}}
                        @if ($mode === 'reset')
                            <div class="mb-3">
                                <label class="form-label">Новый пароль</label>
                                <input type="password" wire:model="newPassword" class="form-control"
                                    placeholder="Введите новый пароль">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Подтверждение пароля</label>
                                <input type="password" wire:model="newPassword_confirmation" class="form-control"
                                    placeholder="Повторите пароль">
                                @error('newPassword')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button wire:click="resetPassword" class="btn btn-success w-100">
                                Сохранить пароль
                            </button>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    @endif
</div>

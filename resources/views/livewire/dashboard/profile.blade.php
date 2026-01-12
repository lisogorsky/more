<div>
    <form wire:submit.prevent="save">

        {{-- 2. Динамические поля профиля --}}
        @if ($activeRole === 3)
            <h3>Данные партнера</h3>

            <input type="text" wire:model="profile.company_name" placeholder="Название компании">

            <input type="text" wire:model="profile.inn" placeholder="ИНН">
        @elseif ($activeRole === 2)
            <h3>Данные организатора</h3>

            {{-- Инфо-блок --}}
            <div class="profile-info">
                <div class="info-item">
                    <strong>Название организации:</strong>
                    <span>{{ $profile['name'] ?? 'Не указано' }}</span>
                </div>

                <div class="info-item">
                    <strong>Описание:</strong>
                    <p>{{ $profile['description'] ?? 'Описание отсутствует' }}</p>
                </div>
            </div>

            {{-- Форма --}}
            <div class="form-group">
                <label>Название организации</label>
                <input type="text" wire:model="profile.name" placeholder="Введите название">

                @error('profile.name')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Описание</label>
                <textarea wire:model="profile.description" placeholder="Расскажите о себе или организации" rows="4"></textarea>

                @error('profile.description')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Публичный адрес (Slug)</label>
                <input type="text" wire:model="profile.public_slug" placeholder="my-org-name">

                @error('profile.public_slug')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
        @elseif ($activeRole === 1)
            <h3>Данные участника</h3>

            <input type="text" wire:model="profile.bio" placeholder="О себе">
        @endif

        <hr>

        {{-- 3. Загрузка фото --}}
        <div class="photo-upload-wrapper">
            <label>
                {{ $activeRole === 1 ? 'Ваш аватар' : 'Логотип организации' }}
            </label>

            <div class="current-photo">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" width="150">
                @else
                    @php
                        $currentImage = $profile['logo'] ?? ($profile['avatar'] ?? null);
                    @endphp

                    @if ($currentImage)
                        <img src="{{ asset('storage/' . $currentImage) }}" width="150">
                    @else
                        <img src="{{ asset('images/default-placeholder.png') }}" width="150">
                    @endif
                @endif
            </div>

            <input type="file" wire:model="photo">

            <div wire:loading wire:target="photo">
                Загрузка файла...
            </div>

            @error('photo')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <hr>

        {{-- 4. Кнопка --}}
        <div class="form-actions">
            <button type="submit" class="btn-save">
                Сохранить изменения
            </button>

            <div wire:loading wire:target="save">
                Сохранение...
            </div>
        </div>

    </form>
</div>
